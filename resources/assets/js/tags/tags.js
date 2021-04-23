'use strict';

$(document).on('click', '.addTagModal', function () {
    $('#addModal').appendTo('body').modal('show');
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
        url: tagSaveUrl,
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
            processingBtn('#addNewForm','#btnSave');
        },
    });
});

$(document).on('click', '.edit-btn', function (event) {
    let tagId = $(event.currentTarget).data('id');
    renderData(tagId);
});

window.renderData = function (id) {
    $.ajax({
        url: tagUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#tagId').val(result.data.id);
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
    let id = $('#tagId').val();

    let editDescription = $('<div />').
        html($('#editDescription').summernote('code'));
    let empty = editDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#editDescription').summernote('isEmpty')) {
        $('#editDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#editForm', '#btnEditSave', 'reset');
        return false;
    }

    $.ajax({
        url: tagUrl + id,
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

// Show tag details on modal
$(document).on('click', '.show-btn', function (e) {
    let tagId = $(e.currentTarget).attr('data-id');
    $.ajax({
        url: tagUrl + tagId,
        type: 'GET',
        beforeSend: function () {
            startLoader();
        },
        complete: function () {
            stopLoader();
        },
        success: function (result) {
            if (result.success) {
                $('#showName').html('');
                $('#showDescription').html('');
                let elements = document.createElement('textarea');
                elements.innerHTML = result.data.name;
                $('#showName').append(elements.value);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.description;
                let description = element.value;
                $('#showDescription').append(description ? description : 'N/A');
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let tagId = $(event.currentTarget).data('id');
    deleteItemLivewire('deleteTag', tagId, 'Tag');
});

window.addEventListener('deleted', function (data) {
    livewireDeleteEventListener(data, 'Tag');
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
