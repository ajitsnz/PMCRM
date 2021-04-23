'use strict';

$(document).ready(function () {

    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false,
        sideBySide: true,
        maxDate: new Date(),
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });

    $('.due-datepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false,
        sideBySide: true,
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });

    setTimeout(function () {
        if (editData == true && $('.due-datepicker').val() !== '')
            $('.due-datepicker').
                data('DateTimePicker').
                minDate($('.due-datepicker').val());
        else
            $('.due-datepicker').
                data('DateTimePicker').
                minDate(moment().millisecond(0).second(0).minute(0).hour(0));

    }, 1000);

    $('#proposalCurrencyId').select2({
        width: '100%',
        placeholder: 'Select Currency',
    });

    $('#discountTypeSelect').select2({
        width: '100%',
        placeholder: 'Select Discount Type',
    });

    $('.related-select-box').select2({
        width: '100%',
        placeholder: 'Select Option',
    });

    $('.assigned-select-box').select2({
        width: '100%',
        placeholder: 'Select Member',
    });

    $('.currency-select-box').select2({
        width: '100%',
        placeholder: 'Select Currency',
    });

    $('.status-select-box').
        select2({
            width: '100%',
        });

    $('#leadOwnerId').select2({
        width: '100%',
        placeholder: 'Select Lead',
    });

    $('#customerSelectBox').select2({
        width: '100%',
        placeholder: 'Select Customer',
    });

    $('.ownerid-select-box').prop('disabled', true);

    setTimeout(function () {

        if ($('#relatedToId').val() !== '') {
            $('#relatedToId').val($('#relatedToId').val()).trigger('change');
        }

    }, 500);

    $(document).on('change', '.related-select-box', function () {
        let relatedTo = $(this).val();
        $('.ownerid-select-box').prop('disabled', true);
        $('.related-to-field1, .related-to-field2').hide();
        if (relatedTo > 0) {
            $('.related-to-field' + relatedTo).show();
            $('.related-to-field' + relatedTo + ' .ownerid-select-box').
                prop('disabled', false);
        }
        if(relatedTo == 1 ) {
            $('#address_to').html('_ _ _ _ _ _');
            $('#addressStreet,#addressCity,#addressState,#addressZipCode,#addressCountry').val('');
        }
        if (relatedTo == 2) {
            let customerId = $('#customerSelectBox').val();
            if (!isEmpty(customerId)) {
                getCustomerAddress(customerId);
            }
        }
    });

    $(document).on('keyup', '.phone', function () {
        $(this).val($(this).val().
            replace(/[^0-9.]/g, '').
            replace(/(\..*)\./g, '$1'));
    });

    $('#addItemSelectBox').on('select2:select', function () {
        let id = $(this).val();
        $.ajax({
            url: itemUrl + '/' + id + '/edit',
            type: 'GET',
            success: function (result) {
                let item = $('.items-container>tr:last-child').
                    find('.item-name').
                    val();
                if (item !== '') {
                    $('#itemAddBtn').trigger('click');
                }
                let lastItem = $('.items-container>tr:last-child');
                let element = document.createElement('textarea');
                element.innerHTML = result.data.title;
                lastItem.find('.item-name').val(element.value);
                lastItem.find('.item-description').
                    val($(result.data.description).text());
                lastItem.find('.qty').val('1').trigger('keyup');
                lastItem.find('.rate').val(result.data.rate).trigger('keyup');

                let proposalItemTaxes = [];
                if (result.data.first_tax) {
                    proposalItemTaxes.push(result.data.first_tax.id);
                }

                if (result.data.second_tax) {
                    proposalItemTaxes.push(result.data.second_tax.id);
                }

                lastItem.find('.tax-rates').
                    val(proposalItemTaxes).
                    trigger('change');
            },
        });
    });

    /** Proposal Submit */
    $(document).on('click', '#saveAsDraft, #saveAndSend', function (e) {
        let status = $(this).data('status');

        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus();
            return false;
        }
        e.preventDefault();
        let saveForm = document.getElementById('proposalForm');
        let formData = new FormData(saveForm);

        formData.append('status', status);

        let index = 0;
        let title, desc, qty, rate, amount, totalAmount;
        let itemTaxes = [];
        totalAmount = $('.total-numbers').text();
        $('.items-container>tr').each(function () {
            itemTaxes = [];
            title = $(this).find('.item-name').val();
            desc = $(this).find('.item-description').val();
            qty = $(this).find('.qty').val();
            rate = $(this).find('.rate').val();
            amount = $(this).find('.item-amount').text();
            $.each($($(this).find('.tax-rates option:selected')), function () {
                itemTaxes.push($(this).val());
            });

            formData.append('itemsArr[' + index + '][item]', title);
            formData.append('itemsArr[' + index + '][description]', desc);
            formData.append('itemsArr[' + index + '][quantity]', qty);
            formData.append('itemsArr[' + index + '][rate]', rate);
            formData.append('itemsArr[' + index + '][total]', amount);
            formData.append('itemsArr[' + index + '][tax]', itemTaxes);
            index++;
        });

        let taxValue, taxAmount;
        $('#taxesListTable>tr').each(function () {
            taxValue = $(this).find('.tax-value').text();
            taxValue = taxValue.replace('%', '');
            taxAmount = $(this).find('.footer-tax-numbers').text();
            formData.append('taxes[' + taxValue + ']', taxAmount);
        });

        formData.append('total_amount', totalAmount);
        formData.append('sub_total', $('#subTotal').text());

        $.ajax({
            url: proposalStoreURL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                startLoader();
            },
            success: function (result) {
                if (result.success) {
                    let proposalId = result.data.id;
                    window.location = proposalUrl + '/' + proposalId;
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                stopLoader();
            },
        });

    });

    /** Proposal Submit */
    $(document).on('click', '#editSaveSend', function (e) {
        let status = $(this).data('status');

        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus();
            return false;
        }
        e.preventDefault();
        let editForm = document.getElementById('editProposalForm');
        let formData = new FormData(editForm);

        formData.append('status', status);

        let index = 0;
        let title, desc, qty, rate, amount, totalAmount;
        let itemTaxes = [];
        totalAmount = $('.total-numbers').text();
        $('.items-container>tr').each(function () {
            itemTaxes = [];
            title = $(this).find('.item-name').val();
            desc = $(this).find('.item-description').val();
            qty = $(this).find('.qty').val();
            rate = $(this).find('.rate').val();
            amount = $(this).find('.item-amount').text();
            $.each($($(this).find('.tax-rates option:selected')), function () {
                itemTaxes.push($(this).val());
            });

            formData.append('itemsArr[' + index + '][item]', title);
            formData.append('itemsArr[' + index + '][description]', desc);
            formData.append('itemsArr[' + index + '][quantity]', qty);
            formData.append('itemsArr[' + index + '][rate]', rate);
            formData.append('itemsArr[' + index + '][total]', amount);
            formData.append('itemsArr[' + index + '][tax]', itemTaxes);
            index++;
        });

        let taxValue, taxAmount;
        $('#taxesListTable>tr').each(function () {
            taxValue = $(this).find('.tax-value').text();
            taxValue = taxValue.replace('%', '');
            taxAmount = $(this).find('.footer-tax-numbers').text();
            formData.append('taxes[' + taxValue + ']', taxAmount);
        });

        formData.append('total_amount', totalAmount);
        formData.append('sub_total', $('#subTotal').text());
        let id = $('#hdnProposalId').val();

        $.ajax({
            url: proposalEditURL + '/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                startLoader();
            },
            success: function (result) {
                if (result.success) {
                    let proposalId = result.data.id;
                    window.location = proposalEditURL + '/' + proposalId;
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                stopLoader();
            },
        });

    });

    // =============================== start edit js ==============================

    if (typeof (proposalEdit) !== 'undefined' && proposalEdit) {
        $('.related-select-box').trigger('change');
        $('.tax-rates').trigger('change');
        $('.qty').trigger('keyup');
        $('#adjustment').trigger('keyup');
        window.calculateSubTotal();
    }

    //================================== end edit js =====================================

    $('.address-modal').on('show.bs.modal', function () {
        setTimeout(function () {
            $('#addressStreet').focus();
        }, 500);
    });

    window.checkAddressFields = function () {
        return $('#addressStreet,#addressCity,#addressState,#addressZipCode,#addressCountry').
            filter(function () {
                return this.value != '';
            });
    };

    window.showAddressError = function (selector) {
        $('.address-modal').modal('show');
        displayErrorMessage($(selector).data('err-msg'));
    };

    window.checkStreetField = function () {
        if ($.trim($('#addressStreet').val()) === '') {
            showAddressError('#addressStreet');
            return false;
        }
        return true;
    };

    $(document).on('click', '#btnSaveAddress', function () {

        if (!checkStreetField()) {
            return false;
        }

        let zipCode = checkZipcode($('#addressZipCode').val());
        if (!zipCode) {
            return false;
        }

        let addressingAddressForm = $('#addressForm');

        if (typeof createProposalAddress !== 'undefined' &&
            createProposalAddress) {
            if (checkAddressFields().length == 0) {
                $('#address_to').html('_ _ _ _ _ _');
            } else {
                $('#address_to').html(createAddressDetail(addressingAddressForm));
            }
        }

        if (typeof editProposalAddress !== 'undefined' &&
            editProposalAddress) {
            if (checkAddressFields().length == 0) {
                $('#address_to').html('_ _ _ _ _ _');
            } else {
                $('#address_to').html(getAddressDetail(addressingAddressForm));
            }
        }

        $('.address-modal').modal('hide');
    });

    function getCustomerAddress(customerId){
        $.ajax({
            url: customerURL,
            type: 'GET',
            data: { customer_id: customerId },
            success: function (result) {
                if (result.success) {
                    if (!isEmpty(result.data)) {
                        let address = result.data;
                        $('#address_to').empty();
                        $('#address_to').
                            append('<span>' + address.street + ',</span><br>');
                        $('#address_to').
                            append('<span>' + address.city + ', </span>');
                        $('#address_to').
                            append('<span>' + address.state + ',</span><br>');
                        $('#address_to').
                            append('<span>' + address.country + ' - </span>');
                        $('#address_to').
                            append('<span>' + address.zip + '</span>');

                        $('#addressStreet').val(result.data.street);
                        $('#addressCity').val(result.data.city);
                        $('#addressState').val(result.data.state);
                        $('#addressZipCode').val(result.data.zip);
                        $('#addressCountry').val(result.data.country);
                    }
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    }

    $(document).on('change', '#customerSelectBox', function () {
        const customer_id = $(this).val();
        if(!isEmpty(customer_id)){
            getCustomerAddress(customer_id)
        }
    });
});

