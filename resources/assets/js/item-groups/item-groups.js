'use strict';

let tableName = '#itemGroupsTable';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: itemGroupUrl,
    },
    columnDefs: [
        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '5%',
        },
        {
            'targets': [2],
            'orderable': true,
            'searchable': false,
            'className': 'text-center',
            'width': '8%',
        },
        {
            'targets': [1],
            render: function (data) {
                return data.length > 80 ?
                    data.substr(0, 80) + '...' :
                    data;
            },
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.name;
                return element.value;
            },
            name: 'name',
        },
        {
            data: function (row) {
                if (row.description != null) {
                    let element = document.createElement('textarea');
                    element.innerHTML = row.description;
                    return element.value;
                } else
                    return 'N/A';
            },
            name: 'description',
        },
        {
            data: 'items_count',
            name: 'items_count',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#itemGroupActionTemplate', data);
            }, name: 'id',
        },
    ],
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');

    let description = $('<div />').
        html($('#createDescription').summernote('code'));
    let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#createDescription').summernote('isEmpty')) {
        $('#createDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#addNewForm', '#btnSave', 'reset');
        return false;
    }

    $.ajax({
        url: itemGroupUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $('#itemGroupsTable').DataTable().ajax.reload(null, false);
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
    let itemGroupId = $(event.currentTarget).data('id');
    renderData(itemGroupId);
});

window.renderData = function (id) {
    $.ajax({
        url: itemGroupUrl + '/' + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#itemGroupId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.name;
                $('#editName').val(element.value);
                $('#editDescription').
                    summernote('code', result.data.description);
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
    let id = $('#itemGroupId').val();

    let $editDescription = $('<div />').
        html($('#editDescription').summernote('code'));
    let empty = $editDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#editDescription').summernote('isEmpty')) {
        $('#editDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#editForm', '#btnEditSave', 'reset');
        return false;
    }

    $.ajax({
        url: itemGroupUrl + '/' + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $('#itemGroupsTable').DataTable().ajax.reload(null, false);
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

$(document).on('click', '.delete-btn', function (event) {
    let itemGroupId = $(event.currentTarget).data('id');
    deleteItem(itemGroupUrl + '/' + itemGroupId, '#itemGroupsTable',
        'Product Group');
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
    $('#createDescription').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});
