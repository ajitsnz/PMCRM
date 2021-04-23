'use strict';

$(document).ready(function () {

    $('#sourceId').select2({
        width: '100%',
        placeholder: 'Select Source',
    });

    $('#statusId').select2({
        width: '100%',
        placeholder: 'Select Status',
    });

    $('#tagId').select2({
        width: '100%',
        placeholder: '  Select Tags',
    });

    $('#memberId,#countryId,#languageId').select2({
        width: '100%',
    });

    window.toggleDateField = function (selector) {
        if ($(selector).prop('checked') === true) {
            $('#contactForm').slideUp();
        } else {
            $('#contactForm').slideDown();
        }
    };

    $(document).on('change', '#checkContact', function () {
        toggleDateField('#checkContact');
    });

    if (typeof isEdit !== 'undefined' && isEdit) {
        toggleDateField('#checkContact');
    }

    $('#contactDateId').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: true,
        sideBySide: true,
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });

    $('#leadDescription').summernote({
        minHeight: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]],
    });

    $(document).on('submit', '#createLead, #editLead', function () {
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');

        let description = $('<div />').
            html($('#leadDescription').summernote('code'));
        let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

        if ($('#leadDescription').summernote('isEmpty')) {
            $('#leadDescription').val('');
        } else if (empty) {
            displayErrorMessage(
                'Description field is not contain only white space');
            let loadingButton = jQuery(this).find('#btnSave');
            loadingButton.button('reset');
            return false;
        }

        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus();
            return false;
        }
    });

    $(document).on('blur', '#website', function () {
        let website = $(this).val();

        if (isEmpty(website)) {
            $('#website').val('');
        } else {
            website = websiteURLConvert(website);
            $('#website').val(website);
        }
    });

    window.websiteURLConvert = function (website) {
        if (!~website.indexOf('http')) {
            website = 'http://' + website;
        }

        return website;
    };

});
