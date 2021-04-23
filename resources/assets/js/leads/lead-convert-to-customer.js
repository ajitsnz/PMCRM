'use strict';

function isEmail (customerEmail) {
    let regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    let checkEmail = regex.test(customerEmail);
    return checkEmail;
}

$(document).on('blur', '#convertWebsite', function () {
    let website = $(this).val();
    if (isEmpty(website)) {
        $('#convertWebsite').val('');
    } else {
        website = websiteURLConvert(website);
        $('#convertWebsite').val(website);
    }
});

window.websiteURLConvert = function (website) {
    if (!~website.indexOf('http')) {
        website = 'http://' + website;
    }

    return website;
};

$(document).ready(function () {
    $('#convertLanguageId,#convertGroupId,#convertCountryId').select2({
        width: '100%',
    });

    $(document).on('click', '#leadConvertToCustomer', function () {
        let companyName = $('.companyName').text();
        let websiteName = $('.leadWebsite').val();
        let country = $('.countryId').val();
        let language = $('.defaultLanguage').val();

        $('#companyName').val((!isEmpty(companyName) ? companyName : ''));
        $('#convertWebsite').val((!isEmpty(websiteName) ? websiteName : ''));
        if(!isEmpty(language)){
            $('#convertLanguageId').val(language).trigger('change');
        }
        if(!isEmpty(country)){
            $('#convertCountryId').val(country).trigger('change');
        }
        $('#convertToCustomer').appendTo('body').modal('show');

    });

    $('#convertToCustomer').on('hidden.bs.modal', function () {
        resetModalForm('#leadConvertToCustomerForm', '#validationErrorsBox');
        $('#convertLanguageId').val('').trigger('change');
        $('#convertCountryId').val('').trigger('change');
    });

    $(document).on('submit', '#leadConvertToCustomerForm', function (e) {
        e.preventDefault();

        if (!isEmail($('#emailId').val())) {
            displayErrorMessage('Email Id Is Invalid');
            return false;
        }

        processingBtn('#leadConvertToCustomerForm', '#btnConvertLeadToCustomer',
            'loading');
        $.ajax({
            url: leadConvertCustomer,
            type: 'POST',
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    $('#convertToCustomer').modal('hide');
                    $('#leadConvertToCustomer').hide();
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                processingBtn('#leadConvertToCustomerForm','#btnConvertLeadToCustomer');
            },
        });
    });
});
