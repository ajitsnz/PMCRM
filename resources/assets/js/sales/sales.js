'use strict';

$(document).ready(function () {
    
    setTimeout(function () {
        $('#invoiceCurrencyId, #creditNoteCurrencyId, #proposalCurrencyId, #estimateCurrencyId').trigger('change');
    }, 500);

    $('.tags-select-box').select2({
        width: '100%',
        placeholder: '   Select Tags',
        multiple: true,
    });

    $('.tax-rates').select2({
        width: '100%',
        placeholder: 'Select Tax',
        multiple: true,
    });

    $('.payment-modes').select2({
        width: '100%',
        placeholder: '   Select Payment Mode',
        multiple: true,
    });

    $('.status').select2({
        width: '100%',
        placeholder: 'Select Status',
    });

    $('.currency-select-box, .sale-agent-select-box, #customerSelectBox').
        select2({
            width: '100%',
            placeholder: 'Select Customer',
        });

    $('#addItemSelectBox').select2({
        width: '87%',
        placeholder: 'Add Product',
    });

    $('#billTaskSelectBox').select2({
        width: '87%',
        placeholder: 'Bill Tasks',
    });

    $('#recurringInvoiceSelect, #discountTypeSelect').select2();

    window.renderOptions = function () {
        let lastItemTaxbox = $('.items-container>tr:last-child').
            find('.tax-rates');
        taxData.forEach(function (data) {
            let newOption = new Option(
                data.tax_rate,
                data.id,
                false,
                false,
            );

            lastItemTaxbox.select2({
                width: '100%',
                placeholder: 'Select tax',
            });
            lastItemTaxbox.append(newOption).trigger('change');
        });
    };

    if ((typeof (isCreate) !== 'undefined')) {
        renderOptions();
    }

    $(document).on('click', '#itemAddBtn', function (e) {
        e.preventDefault();
        const invoiceItemHtml = prepareTemplateRender(
            '#invoiceItemTemplate');
        $('.items-container').append(invoiceItemHtml);
        $('#invoiceCurrencyId, #creditNoteCurrencyId, #proposalCurrencyId, #estimateCurrencyId').trigger('change');
        renderOptions();
    });

    $(document).on('change', '#shippingAddressEnable', function () {
        if ($(this).prop('checked') == true) {
            $('#shippingAddressForm').slideToggle();
        } else {
            $('#shippingAddressForm').slideToggle();
        }
    });

    $(document).on('click', '.remove-invoice-item', function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        calculateSubTotal();
    });

//    invoice item calculation

    $(document).on('keyup', '.qty', function () {
        $(this).
            val($(this).
                val().
                replace(/[^0-9.]/g, '').
                replace(/(\..*)\./g, '$1'));
        let qty = $(this).val();
        let rate = removeCommas($(this).parent().next().find('.rate').val());
        calculateItemAmount(qty, rate, $(this));
        calculateSubTotal();
        $('.tax-rates').trigger('change');
    });

    $(document).on('keyup', '.rate', function () {
        let rate = removeCommas($(this).val());
        let qty = 0;
        if ($(this).val() != '') {
            $(this).val(getFormattedPrice(rate));
            qty = $(this).parent().prev().find('.qty').val();
        }

        calculateItemAmount(qty, rate, $(this));
        calculateSubTotal();
        $('.tax-rates').trigger('change');
    });

    window.calculateItemAmount = (qty, rate, ele) => {
        let itemAmount = qty * rate;
        if (!isNaN(itemAmount)) {
            ele.parent().
                siblings().
                children('.item-amount').
                text(getFormattedPrice(itemAmount));
        }
    };

    let subTotal = 0;
    window.calculateSubTotal = () => {
        subTotal = 0;
        $('.items-container>tr').each(function () {
            let itemAmount = $(this).find('.item-amount').text();
            subTotal += parseFloat(removeCommas(itemAmount));
            subTotal = parseFloat(subTotal);
        });

        $('#subTotal').text(getFormattedPrice(subTotal));
        calculateFinalTotal();
        if (checkDiscountType()) {
            $('#footerDiscount').trigger('change');
        }
    };

    $(document).on('change', '#discountTypeSelect', function () {
        $('#footerDiscount').trigger('change');
        if ($(this).val() == 0) {
            $('#footerDiscount').val(0);
        } else {
            $('#footerDiscount').val(1);
        }
    });

    let footerDiscountType = 1;
    $(document).on('change', '#footerDiscount', function () {
        if (checkDiscountType()) {
            footerDiscountType = $(this).val();
            $('.footer-discount-input').trigger('keyup');
            return false;
        }

        $('.footer-discount-input').val(0);
        $('.footer-discount-input').trigger('keyup');
    });

    let discount = 0;
    $(document).on('keyup', '.footer-discount-input', function () {
        if ($(this).val() != '') {
            let currentVal = $(this).
                val().
                replace(/[^0-9.]/g, '').
                replace(/(\..*)\./g, '$1');
            $(this).val(parseFloat(currentVal));
        } else {
            $(this).val(0);
        }

        if (checkDiscountType() === '' && $(this).val() > 0) {
            alert('please select discount type first');
        } else {
            prepareSelectedTaxes();
            discount = 0;
            let discountType = checkDiscountType();
            if (discountType == 1) {
                $('.footer-discount-numbers').
                    text(getFormattedPrice(-($(this).val())));
                if (footerDiscountType == 1) {
                    let discountPercentage = $(this).val();
                    discountPercentage = (discountPercentage > 100)
                        ? 100
                        : discountPercentage;
                    $(this).val(discountPercentage);
                    let total1 = (parseFloat(subTotal) *
                        parseFloat(discountPercentage)) /
                        100;
                    $('.footer-discount-numbers').
                        text(getFormattedPrice(-(total1)));
                }
            } else if (discountType == 2) {
                $('.footer-discount-numbers').
                    text(getFormattedPrice(-($(this).val())));
                if (footerDiscountType == 1) {
                    let discountPercentage = $(this).val();
                    discountPercentage = (discountPercentage > 100)
                        ? 100
                        : discountPercentage;
                    $(this).val(discountPercentage);
                    $('.footer-discount-numbers').
                        text(getFormattedPrice(
                            -(subTotal + totalOfAllTaxes) * discountPercentage /
                            100));
                    let total2 = parseFloat(totalOfAllTaxes) +
                        parseFloat(subTotal);
                    total2 = total2 * parseFloat(discountPercentage) / 100;
                    $('.footer-discount-numbers').
                        text(getFormattedPrice(-(total2)));
                }
            } else {
                $('.footer-discount-numbers').
                    text(getFormattedPrice(-($(this).val())));
                $(this).val(0);
                let subTotalIncludingTaxes = getSubTotalIncludingTaxes();
                $('.footer-discount-numbers').
                    text(getFormattedPrice((subTotalIncludingTaxes *
                        parseFloat(-($(this).val()))) / 100));
            }

            discount = parseFloat(
                removeCommas($('.footer-discount-numbers').text()));
            prepareSelectedTaxes();
            calculateFinalTotal();
        }
    });

    window.getSubTotalWithDiscount = () => {
        return subTotal + discount;
    };

    $(document).on('mousewheel', '#adjustment', function () {
        $(this).blur();
    });

    let adjustment = 0;
    $(document).on('keyup', '#adjustment', function () {
        adjustment = ($(this).val() == '') ? 0 : $(this).val();
        $('.adjustment-numbers').text(getFormattedPrice(adjustment));
        calculateFinalTotal();
    });

    window.checkDiscountType = () => {
        let discountType = $('#discountTypeSelect').val();
        if (discountType != '' && discountType == 0) {
            $('.footer-discount-input').val('');
            $('#footerDiscount').val(0);
            $('.fDiscount').hide();
        }
        if (discountType == 1 || discountType == 2) {
            $('.fDiscount').show();
            return discountType;
        }
    };

    let taxes = [];
    $(document).on('change', '.tax-rates', function () {
        prepareSelectedTaxes();
        if (checkDiscountType()) {
            $('#footerDiscount').trigger('change');
        }
        calculateFinalTotal();
    });

    let taxPerItems = { 'items': [] };

    window.prepareSelectedTaxes = () => {
        taxes = [];
        taxPerItems.items = [];
        $('.items-container>tr').each(function () {
            let itemTax = [];
            $.each($(this).find('.tax-rates option:selected'), function () {
                itemTax.push($(this).text());
            });

            taxes = [...taxes, ...itemTax];
            let itemRate = removeCommas($(this).find('.item-amount').text());
            taxPerItems.items.push({ [itemTax]: itemRate });

        });
        taxes = Array.from(new Set(taxes));
        renderTaxList();
    };

    let totalOfAllTaxes = 0;
    let discountInNumber = 0;
    window.renderTaxList = function () {
        discountInNumber = $('.footer-discount-input').val();
        totalOfAllTaxes = 0;
        $('#taxesListTable').html('');
        let subTotalForTax = (checkDiscountType() == 1)
            ? getSubTotalWithDiscount()
            : subTotal;
        taxes.forEach(ele => {

            let itemAmount = 0;
            taxPerItems.items.forEach(itemsArr => {
                $.each(itemsArr, function (i, v) {
                    let multipleTaxes = (i.split(',')); // taxt1, tax2 = return array
                    multipleTaxes.forEach(tax => { // ele should be tax value
                        if (tax != ele) {
                            return;
                        }

                        itemAmount = (parseFloat(itemAmount) + parseFloat(v));
                    });
                });
            });

            let calculatedTax = 0;

            if ($('#discountTypeSelect').val() == 0) {
                calculatedTax = getFormattedPrice(
                    parseFloat(itemAmount) * parseFloat(ele) /
                    100);
            } else if ($('#discountTypeSelect').val() == 1) {
                let amt1 = getFormattedPrice(
                    (parseFloat(itemAmount) * parseFloat(discountInNumber)) /
                    100);
                calculatedTax = getFormattedPrice(
                    (parseFloat(itemAmount) -
                        parseFloat(amt1 ? removeCommas(amt1) : 0)) *
                    ele / 100);
            } else if ($('#discountTypeSelect').val() == 2) {
                calculatedTax = getFormattedPrice(
                    (parseFloat(itemAmount) * parseFloat(ele)) /
                    100);
            }
            totalOfAllTaxes += parseFloat(removeCommas(calculatedTax));

            let data = [
                {
                    'tax_name': ele,
                    'tax_rate': calculatedTax,
                }];
            const taxOptionHtml = prepareTemplateRender('#taxesList', data);
            $('#taxesListTable').append(taxOptionHtml);
        });
    };

    window.getSubTotalIncludingTaxes = () => {
        return subTotal - totalOfAllTaxes;
    };

    window.calculateFinalTotal = () => {
        let discountType = $('#discountTypeSelect').val();
        if (discountType == 0) {
            $('.total-numbers').
                text(getFormattedPrice(
                    parseFloat(subTotal) + parseFloat(totalOfAllTaxes) +
                    parseFloat(adjustment)));
        } else if (discountType == 1) {
            let ttl1 = getFormattedPrice(
                parseFloat(subTotal) + parseFloat(totalOfAllTaxes) +
                parseFloat(adjustment) + parseFloat(discount));
            $('.total-numbers').text(ttl1);
        } else if (discountType == 2) {
            let newTotal = (parseFloat(totalOfAllTaxes) + parseFloat(subTotal));
            newTotal = (newTotal + parseFloat(discount));
            $('.total-numbers').
                text(getFormattedPrice(newTotal + parseFloat(adjustment)));
        }
    };

    window.getCurrencyFormatted = function (number) {
        return getFormattedPrice(number);
    };

    window.getAddressDetail = (ele) => {
        if(typeof editData !== "undefined" && editData) {
            let data = [
                {
                    street: ele.find('.street').val(),
                    city: ele.find('.city').val(),
                    state: ele.find('.state').val(),
                    country: ele.find('.country').val(),
                    zip_code: ele.find('.zip-code').val(),
                },
            ];
            return prepareTemplateRender('#addressTemplate', data);
        }
    };

    window.createAddressDetail = (ele) => {
        if (typeof createData !== 'undefined' && createData) {
            let data = [
                {
                    street: ele.find('.street').val(),
                    city: ele.find('.city').val(),
                    state: ele.find('.state').val(),
                    country: ele.find('.country').val(),
                    zip_code: ele.find('.zip-code').val(),
                },
            ];
            return prepareTemplateRender('#createAddressTemplate', data);
        }
    };

    setTimeout(function () {
        $('.address-modal').trigger('hidden.bs.modal');
    }, 100);

    setTimeout(function () {
        $('#addModal').trigger('hidden.bs.modal');
    }, 100);
    
    // change the table header when the radio button is changed from the Show As Quantity section.
    let quantityAs = {'qty' : 'qty', 'hours' : 'hours', 'qtyHours' : 'qtyHours'};
    $('#qty, #hours, #qtyHours').on('change', function () {
        const qtyAs = quantityAs[$(this).data('quantity-for')];
        if($(this).data('quantity-for') === qtyAs && $(this).prop('checked'))
            $('.qtyHeader').text($(this).next().text());
    });
    
    // on edit mode, change the table header based on the selected option.
    if(typeof editData !== "undefined" && editData)
        $('#qty, #hours, #qtyHours').trigger('change');
    
    // change currency icon based on their selected value
    let currenciesIconClass = {
        0 : 'fas fa-rupee-sign',
        1 : 'fas fa-dollar-sign',
        2: 'fas fa-dollar-sign',
        3: 'fas fa-euro-sign',
        4: 'fas fa-yen-sign',
        5: 'fas fa-pound-sign',
        6: 'fas fa-dollar-sign',
    };
    $('#invoiceCurrencyId, #creditNoteCurrencyId, #proposalCurrencyId, #estimateCurrencyId').
        on('change input', function () {
            const currencyIndex = $(this).val();
            $(document).
                find('[data-set-currency-class=\'true\']').
                attr('class', currenciesIconClass[currencyIndex]);
        });

    $(document).on('blur', '#adjustment', function () {
        let adjustment = $(this).val();
        if (isEmpty(adjustment)) {
            $('#adjustment').val('0');
        }
    });

});
