'use strict';

$(document).on('click', '.addAnnouncementModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('change', '#filterAnnouncementStatus', function () {
    window.livewire.emit('filterStatus', $(this).val());
});

$(document).on('mouseenter', '.announcement-card', function () {
    $(this).find('.action-dropdown').removeClass('d-none');
});

$(document).on('mouseleave', '.announcement-card', function () {
    $(this).find('.action-dropdown').addClass('d-none');
    $(this).parent().trigger('click');
});

$('#announcementDate, #editAnnouncementDate').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    useCurrent: false,
    sideBySide: true,
    widgetPositioning: {
        horizontal: 'left',
        vertical: 'bottom',
    },
    icons: {
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        next: 'fa fa-chevron-right',
        previous: 'fa fa-chevron-left',
    },
    minDate: moment().subtract(1, 'days'),
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');

    let $description = $('<div />').
        html($('#createMessage').summernote('code'));
    let empty = $description.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#createMessage').summernote('isEmpty')) {
        $('#createMessage').val('');
    } else if (empty) {
        displayErrorMessage(
            'Message field is not contain only white space');
        processingBtn('#addNewForm', '#btnSave', 'reset');
        return false;
    }

    $.ajax({
        url: announcementSaveUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                window.livewire.emit('refresh');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#addNewForm', '#btnSave');
        },
    });
});

$(document).on('click', '.edit-btn', function (event) {
    let announcementId = $(event.currentTarget).data('id');
    renderData(announcementId);
});

window.renderData = function (id) {
    $.ajax({
        url: announcementUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#announcementId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.subject;
                $('#editSubject').val(element.value);
                $('#editAnnouncementDate').
                    val(moment(result.data.date).
                        utc().
                        format('YYYY-MM-DD HH:mm:ss'));
                $('#editMessage').summernote('code', result.data.message);
                if (result.data.show_to_clients === true)
                    $('#editShowToClients').prop('checked', true);
                else
                    $('#editShowToClients').prop('checked', false);

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
    processingBtn('#editForm', '#btnEditSave', 'loading');
    let id = $('#announcementId').val();

    let $editDescription = $('<div />').
        html($('#editMessage').summernote('code'));
    let empty = $editDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#editMessage').summernote('isEmpty')) {
        $('#editMessage').val('');
    } else if (empty) {
        displayErrorMessage(
            'Message field is not contain only white space');
        processingBtn('#editForm', '#btnEditSave', 'reset');
        return false;
    }

    $.ajax({
        url: announcementUrl + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                window.livewire.emit('refresh');
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

$(document).on('click', '.delete-btn', function () {
    let announcementId = $(this).attr('data-id');
    deleteItemLiveWire(announcementUrl + announcementId, 'Announcement');
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
    $('#createMessage').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

$(document).on('change', '#showToClients', function () {
    let announcementId = $(this).attr('data-id');
    activeDeActiveClient(announcementId);
});

window.activeDeActiveClient = function (id) {
    $.ajax({
        url: announcementUrl + id + '/active-deactive-client',
        method: 'post',
        cache: false,
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                window.livewire.emit('refresh');
            }
        },
        complete: function () {
            stopLoader();
        },
    });
};

// Change status
$(document).on('change', '#announcementStatus', function () {
    let announcementId = $(this).attr('data-id');
    $.ajax({
        url: announcementUrl + announcementId + '/change-status',
        method: 'post',
        cache: false,
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                window.livewire.emit('refresh');
            }
        },
        complete: function () {
            stopLoader();
        },
    });
});

$(document).ready(function () {
    $('#filterAnnouncementStatus').select2();
});
