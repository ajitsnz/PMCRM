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

    $('#estimateCurrencyId').select2({
        width: '100%',
        placeholder: 'Select Currency',
    });

    $('#discountTypeSelect').select2({
        width: '100%',
        placeholder: 'Select Discount Type',
    });

    $('#saleAgentId').select2({
        width: '100%',
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

                let invoiceItemTaxes = [];
                if (result.data.first_tax) {
                    invoiceItemTaxes.push(result.data.first_tax.id);
                }

                if (result.data.second_tax) {
                    invoiceItemTaxes.push(result.data.second_tax.id);
                }

                lastItem.find('.tax-rates').
                    val(invoiceItemTaxes).
                    trigger('change');
            },
        });
    });

    /** Estimate Submit */
    $(document).on('click', '#saveAsDraft, #saveAndSend', function (e) {
        let status = $(this).data('status');

        e.preventDefault();
        let saveForm = document.getElementById('estimateForm');
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
            url: storeEstimateUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                startLoader();
            },
            success: function (result) {
                if (result.success) {
                    let estimateId = result.data.id;
                    window.location = estimateUrl + '/' + estimateId;
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

    /** Edit Estimate Submit */
    $(document).on('click', '#editSaveSend', function (e) {
        let status = $(this).data('status');

        if ($('#editAdminNote').summernote('isEmpty')) {
            $('#editAdminNote').val('');
        }

        if ($('#editClientNote').summernote('isEmpty')) {
            $('#editClientNote').val('');
        }

        if ($('#editTermAndConditions').summernote('isEmpty')) {
            $('#editTermAndConditions').val('');
        }

        e.preventDefault();
        let editForm = document.getElementById('editEstimateForm');
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
        let id = $('#estimateId').val();

        $.ajax({
            url: estimateEditURL + '/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                startLoader();
            },
            success: function (result) {
                if (result.success) {
                    let estimateId = result.data.id;
                    window.location = estimateEditURL + '/' + estimateId;
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

    if (typeof (estimateEdit) !== 'undefined' && estimateEdit) {
        $('.tax-rates').trigger('change');
        $('.qty').trigger('keyup');
        $('#adjustment').trigger('keyup');
        window.calculateSubTotal();
        $('#estimateNumber').attr('readonly', true);
        $('.address-modal').trigger('hidden.bs.modal');
    }

    //================================== end edit js =====================================

    $('.address-modal').on('show.bs.modal', function () {
        setTimeout(function () {
            $('#billStreet').focus();
        }, 500);
    });

    window.checkBillAddressFields = function () {
        return $('#billStreet,#billCity,#billState,#billZipCode,#billCountry').
            filter(function () {
                return this.value != '';
            });
    };

    window.showBillingShippingAddressError = function (selector) {
        $('.address-modal').modal('show');
        displayErrorMessage($(selector).data('err-msg'));
    };

    let shippingData = '';
    $(document).on('change', '#shippingAddressEnable', function () {
        if (!$(this).prop('checked') &&
            (typeof createData !== 'undefined' || typeof editData !==
                'undefined')) {
            $('#shipStreet').val('');
            $('#copyBillingAddress').prop('checked', false);
            $('#shipStreet,#shipCity,#shipState,#shipZipCode,#shipCountry').val('');
        }
    });

    window.checkStreetField = function () {
        if ($.trim($('#billStreet').val()) === '') {
            showBillingShippingAddressError('#billStreet');
            return false;
        } else if ($('#shippingAddressEnable').prop('checked') &&
            $.trim($('#shipStreet').val()) === '') {
            showBillingShippingAddressError('#shipStreet');
            return false;
        }

        return true;
    };

    $(document).on('click', '#btnSave', function () {

        if (!checkStreetField()) {
            return false;
        }

        let billZipCode = checkZipcode($('#billZipCode').val());
        if (!billZipCode) {
            return false;
        }

        if ($('#shippingAddressEnable').prop('checked')) {
            let shipZipCodeValue = $('#shipZipCode').val();
            let shipZipCode = checkZipcode(shipZipCodeValue);
            if (!shipZipCode) {
                return false;
            }
        }

        let billingAddressForm = $('#addressForm');
        let shippingAddressForm = $('#shippingAddressForm');

        if (typeof createEstimateAddress !== 'undefined' &&
            createEstimateAddress) {
            if (checkBillAddressFields().length == 0) {
                $('#bill_to').html('_ _ _ _ _ _');
            } else {
                $('#bill_to').html(createAddressDetail(billingAddressForm));
            }

            if ($('#shippingAddressEnable').prop('checked') == true &&
                $('#shipStreet').val() != '') {
                $('#ship_to').html(createAddressDetail(shippingAddressForm));
            } else {
                $('#ship_to').html('_ _ _ _ _ _');
            }
        }

        if (typeof editEstimateAddress !== 'undefined' && editEstimateAddress) {
            if (checkBillAddressFields().length == 0) {
                $('#bill_to').html('_ _ _ _ _ _');
            } else {
                $('#bill_to').html(getAddressDetail(billingAddressForm));
            }

            if ($('#shippingAddressEnable').prop('checked') == true &&
                $('#shipStreet').val() != '') {
                $('#ship_to').html(getAddressDetail(shippingAddressForm));
            } else {
                $('#ship_to').html('_ _ _ _ _ _');
            }
        }

        $('.address-modal').modal('hide');
    });

    if (typeof editData !== 'undefined') {
        if ($.trim($('#shipStreet').val()) !== '') {
            $('#shippingAddressEnable').prop('checked', true);
            $('#shippingAddressForm').slideDown();
            shippingData = $('#shipStreet').val();
        }
    }

    $(document).on('change', '#customerSelectBox', function () {
        const customer_id = $(this).val();
        $('#shippingAddressEnable').prop('checked', false);
        $('#shippingAddressForm').slideUp();
        $('#copyBillingAddress').prop('checked', false);
        $('#billStreet,#billCity,#billState,#billZipCode,#billCountry').val('');
        $('#shipStreet,#shipCity,#shipState,#shipZipCode,#shipCountry').val('');
        $.ajax({
            url: customerURL,
            type: 'GET',
            data: {customer_id: customer_id},
            success: function (result) {
                $("#bill_to").empty();
                $('#ship_to').empty();
                let billAddress = result.data[0];
                let shipAddress = result.data[1];
                $('#copyBillingAddress').prop('checked',true);
                if(! isEmpty(billAddress)) {
                    $("#bill_to").append("<span>" + billAddress.street + '</span><br>');
                    $("#bill_to").append("<span>" + billAddress.city + ',</span>');
                    $("#bill_to").append("<span>" + billAddress.state + '</span><br>');
                    $("#bill_to").append("<span>" + billAddress.country + '-</span>');
                    $("#bill_to").append("<span>" + billAddress.zip + '</span>');

                    $('#billStreet').val(result.data[0].street);
                    $('#billCity').val(result.data[0].city);
                    $('#billState').val(result.data[0].state);
                    $('#billZipCode').val(result.data[0].zip);
                    $('#billCountry').val(result.data[0].country);
                }else{
                    $('#bill_to').html('_ _ _ _ _ _');
                    $('#ship_to').html('_ _ _ _ _ _');
                }
                if(! isEmpty(shipAddress)) {
                    $('#shippingAddressEnable').prop('checked',true);
                    $('#shippingAddressForm').slideDown();

                    $("#ship_to").append("<span>"+shipAddress.street+'</span><br>');
                    $("#ship_to").append("<span>"+shipAddress.city+',</span>');
                    $("#ship_to").append("<span>"+shipAddress.state+'</span><br>');
                    $("#ship_to").append("<span>"+shipAddress.country+'-</span>');
                    $("#ship_to").append("<span>"+shipAddress.zip+'</span>');

                    $('#shipStreet').val(result.data[1].street);
                    $('#shipCity').val(result.data[1].city);
                    $('#shipState').val(result.data[1].state);
                    $('#shipZipCode').val(result.data[1].zip);
                    $('#shipCountry').val(result.data[1].country);
                }else{
                    $('#shippingAddressEnable').prop('checked',false);
                    $('#shippingAddressForm').slideUp();
                    $('#copyBillingAddress').prop('checked',false);
                    $('#ship_to').html('_ _ _ _ _ _');
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    });

    $(document).on('click', '#copyBillingAddress', function () {
        if ($(this).prop('checked')) {
            $('#shipStreet').val($('#billStreet').val());
            $('#shipCity').val($('#billCity').val());
            $('#shipState').val($('#billState').val());
            $('#shipZipCode').val($('#billZipCode').val());
            $('#shipCountry').val($('#billCountry').val());
        }
    });
});
