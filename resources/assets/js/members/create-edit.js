'use strict';

$(document).ready(function () {

    $('#languageId').select2({
        width: '100%',
    });

    $('.price-input').trigger('input');

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
        let $pwd = $('#cPassword');
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
            $('#show_hide_cPassword i').removeClass('fa-eye-slash');
            $('#show_hide_cPassword i').addClass('fa-eye');
        } else {
            $pwd.attr('type', 'password');
            $('#show_hide_cPassword i').addClass('fa-eye-slash');
            $('#show_hide_cPassword i').removeClass('fa-eye');
        }
    });

    $(document).on('keyup', '#facebookUrl', function () {
        this.value = this.value.toLowerCase();
    });

    $(document).on('keyup', '#linkedInUrl', function () {
        this.value = this.value.toLowerCase();
    });

    $(document).on('keyup', '#skypeUrl', function () {
        this.value = this.value.toLowerCase();
    });

    $(document).on('submit', '#createMember, #editMember', function () {
        let facebookUrl = $('#facebookUrl').val();
        let linkedInUrl = $('#linkedInUrl').val();
        let skypeUrl = $('#skypeUrl').val();
        let facebookExp = new RegExp(
            /^(https?:\/\/)?((m{1}\.)?)?((w{2,3}\.)?)facebook.[a-z]{2,3}\/?.*/i);
        let linkedInExp = new RegExp(
            /^(https?:\/\/)?((w{2,3}\.)?)linkedin\.[a-z]{2,3}\/?.*/i);
        let skypeExp = new RegExp(
            /^(https?:\/\/)?((m{1}\.)?)?((w{2,3}\.)?)skype.[a-z]{2,3}\/?.*/i);

        let facebookCheck = (facebookUrl == '' ? true : (facebookUrl.match(
            facebookExp) ? true : false));
        if (!facebookCheck) {
            displayErrorMessage('Please enter a valid Facebook Url');
            return false;
        }

        let linkedInCheck = (linkedInUrl == '' ? true : (linkedInUrl.match(
            linkedInExp) ? true : false));
        if (!linkedInCheck) {
            displayErrorMessage('Please enter a valid Linkedin Url');
            return false;
        }

        let skypeCheck = (skypeUrl == '' ? true : (skypeUrl.match(
            skypeExp) ? true : false));
        if (!skypeCheck) {
            displayErrorMessage('Please enter a valid Skype Url');
            return false;
        }

        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus();
            return false;
        }

        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');

    });

    $(document).on('change', '#logo', function () {
        let validFile = isValidFile($(this), '#validationErrorsBox');
        if (validFile) {
            displayPhoto(this, '#logoPreview');
            $('#btnSave').prop('disabled', false);
        } else {
            $('#btnSave').prop('disabled', true);
        }
    });
});
