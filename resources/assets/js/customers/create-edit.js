'use strict';

$(document).ready(function () {

    $('#groupId').select2({
        width: '100%',
        placeholder: '  Select Groups',
        multiple: true,
    });

    $('#customerId').select2({
        width: '200px',
    });

    $('#currencyId,#countryId,#languageId,#billingCountryId,#shippingCountryId').
        select2({
            width: '100%',
        });

    $(document).on('click', '.addressModalIcon', function () {
        $('#addModal').appendTo('body').modal('show');
    });

    $(document).on('click', '#copyBillingAddress', function () {
        if ($('#shippingAddressCheck').prop('checked') === true) {
            $('#shippingStreet').val($('#billingStreet').val());
            $('#shippingCity').val($('#billingCity').val());
            $('#shippingState').val($('#billingState').val());
            $('#shippingZip').val($('#billingZip').val());
            $('#shippingCountryId').
                val($('#billingCountryId').val()).
                trigger('change.select2');
        } else {
            $('#shippingStreet').val('');
            $('#shippingCity').val('');
            $('#shippingState').val('');
            $('#shippingZip').val('');
            $('#shippingCountryId').
                val('').
                trigger('change.select2');
        }
    });

    $(document).on('change', '#customerId', function () {
        let urlLastString = window.location.href.substring(
            window.location.href.lastIndexOf('/') + 1);
        location.href = !isNaN(urlLastString) ? customerUrl + $(this).val() +
            '/profile' : customerUrl + $(this).val() + '/' + urlLastString;
    });

    $(document).on('submit', '#createCustomer, #editCustomer', function () {
        let shipZipCode = checkZipcode($('#shippingZip').val());
        if (!shipZipCode) {
            return false;
        }

        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus();
            return false;
        }

        var loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');

        $('#btnSave').prop('disabled', true);
    });

    $(document).on('submit', '#addressForm', function (event) {
        event.preventDefault();
        let customerId = $('#customer_id').val();
        $.ajax({
            url: customerAddressUrl,
            type: 'POST',
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    $('#addModal').modal('hide');
                    location.reload();
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                processingBtn('#addNewForm', '#btnSave');
            },
        });
    });

    $(document).on('blur', '#website', function () {
        var website = $(this).val();
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

    $('.address-modal').on('hidden.bs.modal', function () {
        $('#shippingAddressCheck').prop('checked',false);
        $('#billingCountryId,#shippingCountryId').val('').trigger('change');
        resetModalForm('#addressForm', '#validationErrorsBox');
    });
});
