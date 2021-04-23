'use strict';

$(document).on('click', '.addPredefinedReplyModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');

    let createBody = $('<div />').html($('#createBody').summernote('code'));
    let empty = createBody.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#createBody').summernote('isEmpty')) {
        $('#createBody').val('');
    } else if (empty) {
        displayErrorMessage(
            'Body field is not contain only white space');
        processingBtn('#addNewForm', '#btnSave', 'reset');
        return false;
    }

    $.ajax({
        url: predefinedReplySaveUrl,
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
    let predefinedReplyId = $(event.currentTarget).data('id');
    renderData(predefinedReplyId);
});

window.renderData = function (id) {
    $.ajax({
        url: predefinedReplyUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#predefinedReplyId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.reply_name;
                $('#editReplyName').val(element.value);
                $('#editBody').summernote('code', result.data.body);
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
    let id = $('#predefinedReplyId').val();

    let editBody = $('<div />').html($('#editBody').summernote('code'));
    let empty = editBody.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#editBody').summernote('isEmpty')) {
        $('#editBody').val('');
    } else if (empty) {
        displayErrorMessage(
            'Body field is not contain only white space');
        processingBtn('#editForm', '#btnEditSave', 'reset');
        return false;
    }

    $.ajax({
        url: predefinedReplyUrl + id,
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

// Show predefined replay details on modal
$(document).on('click', '.show-btn', function (e) {
    let predefinedReplyId = $(e.currentTarget).attr('data-id');
    $.ajax({
        url: predefinedReplyUrl + predefinedReplyId,
        type: 'GET',
        beforeSend: function () {
            startLoader();
        },
        complete: function () {
            stopLoader();
        },
        success: function (result) {
            if (result.success) {
                $('#showReplyName').html('');
                $('#showBody').html('');
                $('#showReplyName').append(result.data.reply_name);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.body;
                let body = element.value;
                $('#showBody').append(body ? body : 'N/A');
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let predefinedReplyId = $(event.currentTarget).data('id');
    deleteItemLivewire('deletePredefinedReply', predefinedReplyId,
        'Predefined Reply');
});

window.addEventListener('deleted', function (data) {
    livewireDeleteEventListener(data, 'Predefined Reply');
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
    $('#createBody').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});
