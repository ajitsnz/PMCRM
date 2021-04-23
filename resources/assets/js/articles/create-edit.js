'use strict';

$(document).ready(function () {
    $('#groupId').select2({
        width: '100%',
        placeholder: 'Select Group',
    });
});

$(document).on('submit', '#createArticle, #editArticle', function () {
    let loadingButton = jQuery(this).find('#btnSave');
    loadingButton.button('loading');

    let description = $('<div />').
        html($('#articleDescription').summernote('code'));
    let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#articleDescription').summernote('isEmpty')) {
        $('#articleDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('reset');
        return false;
    }

    $('#btnSave').prop('disabled', true);
});

$(document).on('change', '#attachment', function () {
    let validFile = isValidFile($(this), '#validationErrorBox');
    if (!validFile) {
        return false;
    }
});
