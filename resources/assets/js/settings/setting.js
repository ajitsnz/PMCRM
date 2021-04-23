'use strict';

$(document).on('submit', '#settingUpdate', function () {
    if ($('#error-msg').text() !== '') {
        $('#phoneNumber').focus();
        return false;
    }
});

$(document).on('change', '#logo', function () {
    if (isValidFile($(this), '#validationErrorsBox')) {
        displayPhoto(this, '#logoPreview');
    }
});

$(document).on('change', '#favicon', function () {
    if (isValidFile($(this), '#validationErrorsBox')) {
        displayFavicon(this, '#faviconPreview');
    }
});
