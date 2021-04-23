'use strict';

let input = document.querySelector('#phoneNumber'),
    errorMsg = document.querySelector('#error-msg'),
    validMsg = document.querySelector('#valid-msg');

let errorMap = [
    'Invalid number',
    'Invalid country code',
    'Too short',
    'Too long',
    'Invalid number'];

// initialise plugin
let intl = window.intlTelInput(input, {
    initialCountry: 'auto',
    separateDialCode: true,
    customPlaceholder: function () {
        return '99999 99999';
    },
    geoIpLookup: function (success, failure) {
        $.get('//ipinfo.io', function () {}, 'jsonp').
            always(function (resp) {
                let countryCode = (resp && resp.country)
                    ? resp.country
                    : '';
                success(countryCode);
            });
    },
    utilsScript: utilsScript,
});

let reset = function () {
    input.classList.remove('error');
    errorMsg.innerHTML = '';
    errorMsg.classList.add('hide');
    validMsg.classList.add('hide');
};

input.addEventListener('blur', function () {
    reset();
    if (input.value.trim()) {
        if (intl.isValidNumber()) {
            validMsg.classList.remove('hide');
        } else {
            input.classList.add('error');
            let errorCode = intl.getValidationError();
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove('hide');
        }
    }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);

$(document).on('blur keyup change countrychange', '#phoneNumber', function () {
    let getCode = intl.selectedCountryData['dialCode'];
    $('#prefix_code').val(getCode);
});

if (isEdit) {
    let getCode = intl.selectedCountryData['dialCode'];
    $('#prefix_code').val(getCode);
}

let getPhoneNumber = $('#phoneNumber').val();
let removeSpacePhoneNumber = getPhoneNumber.replace(/\s/g, '');
$('#phoneNumber').val(removeSpacePhoneNumber);


