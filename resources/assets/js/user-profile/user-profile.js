'use strict';

$(document).ready(function () {
    $('#defaultLanguage').select2({
        width: '100%',
    });
});

$(document).on('submit', '#changePasswordForm', function (event) {
    event.preventDefault();
    let isValidate = validatePassword();
    if (!isValidate) {
        return false;
    }
    let loadingButton = jQuery(this).find('#btnEditSavePassword');
    loadingButton.button('loading');
    $.ajax({
        url: changePasswordUrl,
        type: 'post',
        data: new FormData($(this)[0]),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                $('#changePasswordModal').modal('hide');
                displaySuccessMessage(result.message);
            }
        },
        error: function (result) {
            manageAjaxErrors(result);
        },
        complete: function () {
            loadingButton.button('reset');
        },
    });
});

$('#editProfileModal').on('hidden.bs.modal', function () {
    resetModalForm('#editProfileForm', '#editProfileValidationErrorsBox');
});

$(document).on('click', '.changeType', function (e) {
    let inputField = $(this).parent().siblings();
    let oldType = inputField.attr('type');
    if (oldType == 'password') {
        $(this).children().addClass('fa-eye');
        $(this).children().removeClass('fa-eye-slash');
        inputField.attr('type', 'text');
    } else {
        $(this).children().removeClass('fa-eye');
        $(this).children().addClass('fa-eye-slash');
        inputField.attr('type', 'password');
    }
});

$('#changePasswordModal').on('hidden.bs.modal', function () {
    resetModalForm('#changePasswordForm', '#editPasswordValidationErrorsBox');
});

function validatePassword () {
    let currentPassword = $('#pfCurrentPassword').val().trim();
    let password = $('#pfNewPassword').val().trim();
    let confirmPassword = $('#pfNewConfirmPassword').val().trim();

    if (currentPassword == '' || password == '' || confirmPassword == '') {
        $('#editPasswordValidationErrorsBox').
            show().
            html('Please fill all the required fields.');
        return false;
    }
    return true;
}

$(document).on('keyup', '#facebookUrl', function () {
    this.value = this.value.toLowerCase();
});

$(document).on('keyup', '#linkedInUrl', function () {
    this.value = this.value.toLowerCase();
});

$(document).on('keyup', '#skypeUrl', function () {
    this.value = this.value.toLowerCase();
});

$(document).on('submit', '#updateProfile', function (e) {
    e.stopImmediatePropagation();

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
});

$(document).on('change', '#profileImage', function () {
    let validFile = isValidFile($(this), '#validationErrorBox');
    if (validFile) {
        displayPhoto(this, '#previewImage');
        $('#btnSave').prop('disabled', false);
    } else {
        $('#btnSave').prop('disabled', true);
    }
});

$(document).on('submit', '#changeLanguageForm', function (event) {
    event.preventDefault();
    let loadingButton = $(this).find('#btnLanguageChange');
    loadingButton.button('loading');

    $.ajax({
        url: changeLanguageUrl,
        type: 'post',
        data: new FormData($(this)[0]),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                $('#changeLanguageModal').modal('hide');
                location.reload();
            }
        },
        error: function (result) {
            manageAjaxErrors(result, '#changeLanguageValidationErrorsBox');
        },
        complete: function () {
            loadingButton.button('reset');
        },
    });
});

$('#changeLanguageModal').on('hidden.bs.modal', function () {
    resetModalForm('#changeLanguageForm', '#changeLanguageValidationErrorsBox');
});
