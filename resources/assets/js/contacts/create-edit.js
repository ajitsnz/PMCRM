'use strict';

$(document).ready(function () {

    $('#customerId').select2({
        width: '100%',
        placeholder: 'Select Customer',
    });

    $(document).on('submit', '#createContact, #editContact', function () {
        var loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');
        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus();
            return false;
        }
    });

    $(document).on('click', '.password-show', function () {
        let $pwd = $('#password');
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
            $('#show_hide_password i').removeClass('fa-eye-slash');
            $('#show_hide_password i').addClass('fa-eye');
        } else {
            $pwd.attr('type', 'password');
            $('#show_hide_password i').addClass('fa-eye-slash');
            $('#show_hide_password i').removeClass('fa-eye');
        }
    });

    $(document).on('click', '.cPassword-show', function () {
        let $cPwd = $('#cPassword');
        if ($cPwd.attr('type') === 'password') {
            $cPwd.attr('type', 'text');
            $('#show_hide_cPassword i').removeClass('fa-eye-slash');
            $('#show_hide_cPassword i').addClass('fa-eye');
        } else {
            $cPwd.attr('type', 'password');
            $('#show_hide_cPassword i').addClass('fa-eye-slash');
            $('#show_hide_cPassword i').removeClass('fa-eye');
        }
    });

    $(document).on('change', '#profileImage', function () {
        let validFile = isValidFile($(this), '#validationErrorsBox');
        if (validFile) {
            displayPhoto(this, '#previewImage');
            $('#btnSave').prop('disabled', false);
        } else {
            $('#btnSave').prop('disabled', true);
        }
    });

});
