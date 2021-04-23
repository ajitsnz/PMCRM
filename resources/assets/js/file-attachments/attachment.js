'use strict';

$(document).ready(function () {
    if (typeof isEdit !== 'undefined') {
        // changing the item stock attachment preview on edit item stock
        const previewSrc = $('#previewImage').attr('src');
        let ext = previewSrc.split('.').pop().toLowerCase();
        if (ext == 'pdf') {
            $('#previewImage').attr('src', pdfDocumentImageUrl);
        } else if ((ext == 'docx') || (ext == 'doc')) {
            $('#previewImage').
                attr('src', docxDocumentImageUrl);
        }
    }
});

$(document).on('change', '#attachment', function () {
    let extension = isValidDocument($(this));
    if (!isEmpty(extension) && extension != false) {
        displayDocument(this, '#previewImage', extension);
    }
});

window.isValidDocument = function (inputSelector) {
    let ext = $(inputSelector).val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
        $(inputSelector).val('');
        displayErrorMessage('File type not allowed.');
        $('#previewImage').attr('src', blockedAttachmentUrl);
        return false;
    }
    return ext;
};

window.isEmpty = (value) => {
    return value === undefined || value === null || value === '';
};

window.displayDocument = function (input, selector, extension) {
    let displayPreview = true;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let image = new Image();
            if ($.inArray(extension, ['pdf', 'doc', 'docx']) == -1) {
                image.src = e.target.result;
            } else {
                if (extension == 'pdf') {
                    image.src = pdfDocumentImageUrl;
                } else {
                    image.src = docxDocumentImageUrl;
                }
            }
            image.onload = function () {
                $(selector).attr('src', image.src);
                displayPreview = true;
            };
        };
        if (displayPreview) {
            reader.readAsDataURL(input.files[0]);
            $(selector).show();
        }
    }
};
