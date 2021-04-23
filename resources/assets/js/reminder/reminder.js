'use strict';

$(document).ready(function () {
    $('#filterNotified').
        select2({
            width: '170px',
        });
});

let tableName = '#reminderTbl';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[1, 'desc']],
    ajax: {
        url: reminderUrl,
        beforeSend: function () {
            startLoader();
        },
        data: function (data) {
            data.module_id = $('#moduleId').val();
            data.owner_id = $('#ownerId').val();

            data.is_notified = $('#filterNotified').
                find('option:selected').
                val();
        },
        complete: function () {
            stopLoader();
        },
    },
    columnDefs: [
        {
            'targets': [5],
            'orderable': false,
            'className': 'text-center',
            'width': '5%',
        },
        {
            'targets': [3],
            'className': 'text-center',
            'orderable': false,
            'width': '9%',
        },
        {
            'targets': [4],
            'className': 'text-center',
            'orderable': false,
            'width': '5%',
        },
        {
            'targets': [0],
            'orderable': false,
            'className': 'text-center',
            'width': '9%',
        },
        {
            'targets': [1],
            'width': '14%',
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: function (row) {
                if (row.owner_type == 'App\\Models\\Customer') {
                    let element = document.createElement('textarea');
                    element.innerHTML = row.contact.user.full_name;
                    return '<img src="' + row.contact.user.image_url +
                        '" class="thumbnail-rounded" data-toggle="tooltip" title="' +
                        element.value + '">';
                }
                let element = document.createElement('textarea');
                element.innerHTML = row.user.full_name;
                return '<img src="' + row.user.image_url +
                    '" class="thumbnail-rounded" data-toggle="tooltip" title="' +
                    element.value + '">';
            },
            name: 'reminder_to',
        },
        {
            data: function (row) {
                return row;
            },
            render: function (row) {
                if (row.notified_date === null) {
                    return 'N/A';
                }

                return moment(row.notified_date).format('Do MMM, Y HH:mm A');
            },
            name: 'notified_date',
        },
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.description;
                return element.value;
            },
            name: 'description',
        },
        {
            data: function (row) {
                let checked = row.is_notified === false ? '' : 'checked';
                let data = [{ 'id': row.id, 'checked': checked }];
                return prepareTemplateRender('#showNotified', data);
            },
            name: 'is_notified',
        },
        {
            data: function (row) {
                let checked = row.status === false ? '' : 'checked';
                let data = [{ 'id': row.id, 'checked': checked }];
                return prepareTemplateRender('#reminderStatus', data);
            },
            name: 'status',
        },
        {
            data: function (row) {
                let data = [
                    {
                        'id': row.id,
                    }];
                return prepareTemplateRender('#reminderActionTemplate',
                    data);
            }, name: 'user.last_name',
        },
    ],
    'fnInitComplete': function () {
        $(document).on('change', '#filterNotified', function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(document).on('click', '.addReminderModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).ready(function () {

    $('#reminderTo,#editReminderTo').select2({
        width: '100%',
    });

    $('#notifiedDate, #editNotifiedDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: true,
        sideBySide: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom',
        },
        minDate: new Date(),
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });

    $('#notifiedDate, #editNotifiedDate').on('dp.show', function () {
        matchWindowScreenPixels(
            {
                notifiedDate: '#notifiedDate',
                editNotifiedDate: '#editNotifiedDate',
            },
            'led');
    });
});

window.checkReminderContent = function (elementSelector) {
    const elSelector = '#' + elementSelector;
    if ($(elSelector).summernote('isEmpty')) {
        displayErrorMessage('Description field is required.');
        return false;
    }

    return true;
};

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();

    if (!checkReminderContent('reminderDescription'))
        return;

    processingBtn('#addNewForm', '#btnCreateSave', 'loading');

    let createDescription = $('<div />').
        html($('#reminderDescription').summernote('code'));
    let empty = createDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#reminderDescription').summernote('isEmpty')) {
        $('#reminderDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#addNewForm', '#btnCreateSave', 'reset');
        return false;
    }

    $.ajax({
        url: reminderSaveUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $('#reminderTbl').DataTable().ajax.reload(null, true);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#addNewForm', '#btnCreateSave');
        },
    });
});

$(document).on('click', '.edit-reminder-btn', function (event) {
    let reminderId = $(event.currentTarget).data('id');
    renderEditData(reminderId);
});

window.renderEditData = function (id) {
    $.ajax({
        url: reminderUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#reminderId').val(result.data.id);
                $('#editNotifiedDate').
                    val(format(result.data.notified_date,
                        'YYYY-MM-DD HH:mm:ss'));
                $('#editReminderTo').
                    val(result.data.reminder_to).
                    trigger('change');
                $('#editReminderDescription').
                    summernote('code', result.data.description);
                if (result.data.is_notified == 1)
                    $('#editIsNotified').prop('checked', true);
                else
                    $('#editIsNotified').prop('checked', false);

                if (result.data.status === true)
                    $('#editStatus').prop('checked', true);
                else
                    $('#editStatus').prop('checked', false);
                $('#editModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};

$(document).on('submit', '#editForm', function (event) {
    event.preventDefault();

    if (!checkReminderContent('editReminderDescription'))
        return;

    processingBtn('#editForm', '#btnEditSave', 'loading');
    let id = $('#reminderId').val();

    let editDescription = $('<div />').
        html($('#editReminderDescription').summernote('code'));
    let empty = editDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#editReminderDescription').summernote('isEmpty')) {
        $('#editReminderDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#editForm', '#btnEditSave', 'reset');
        return false;
    }

    $.ajax({
        url: reminderUrl + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $('#reminderTbl').DataTable().ajax.reload(null, true);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#editForm', '#btnEditSave');
        },
    });
});

$(document).on('click', '.delete-reminder-btn', function (event) {
    let reminderId = $(event.currentTarget).data('id');
    deleteItem(reminderUrl + reminderId, '#reminderTbl',
        'Reminder');
});

$('#addModal').on('show.bs.modal', function () {
    $('.note-toolbar-wrapper').removeAttr('style');
    $('.note-toolbar').removeAttr('style');
});

$('#editModal').on('show.bs.modal', function () {
    $('.note-toolbar-wrapper').removeAttr('style');
    $('.note-toolbar').removeAttr('style');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#reminderDescription').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

$(document).on('change', '.isNotified', function (event) {
    let reminderId = $(event.currentTarget).data('id');
    activeDeActiveNotified(reminderId);
});

window.activeDeActiveNotified = function (id) {
    $.ajax({
        url: reminderUrl + id + '/active-deactive-notified',
        method: 'post',
        cache: false,
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                $('#reminderTbl').DataTable().ajax.reload();
            }
        },
        complete: function () {
            stopLoader();
        },
    });
};

$(tableName).on('draw.dt', function () {
    $('.tooltip').tooltip('hide');
    setTimeout(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});

// Change status
$(document).on('change', '.reminderStatus', function (event) {
    let reminderId = $(event.currentTarget).data('id');
    $.ajax({
        url: reminderUrl + reminderId + '/change-status',
        method: 'post',
        cache: false,
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                $('#reminderTbl').DataTable().ajax.reload(null, false);
            }
        },
        complete: function () {
            stopLoader();
        },
    });
});
