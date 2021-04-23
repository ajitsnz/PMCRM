'use strict';

$(document).ready(function () {

    $('#currency').select2({
        width: '100%',
        placeholder: 'Select Currency',
    });

    $(document).on('submit', '#createExpense, #editExpense', function () {
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');
        if ($('#error-msg').text() !== '') {
            return false;
        }

        let note = $('<div />').html($('#expenseNote').summernote('code'));
        let empty = note.text().trim().replace(/ \r\n\t/g, '') === '';

        if ($('#expenseNote').summernote('isEmpty')) {
            $('#expenseNote').val('');
        } else if (empty) {
            displayErrorMessage(
                'Note field is not contain only white space');
            let loadingButton = jQuery(this).find('#btnSave');
            loadingButton.button('reset');
            return false;
        }

    });

    let oldAmount = 0;

    $('#taxAmount').text(0);

    $('#expenseCategory').select2({
        width: '100%',
        placeholder: 'Select Expense Category',
    });

    $('#customers').select2({
        width: '100%',
    });

    $('#paymentMode').select2({
        width: '100%',
    });

    $('#tax1,#tax2').select2({
        width: '100%',
    });

    $('.price-input').trigger('input');

    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: true,
        sideBySide: true,
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });

    $('.datepicker').on('dp.show', function () {
        matchWindowScreenPixels(
            { expenseDate: '.datepicker' },
            'exp');
    });

    $(document).on('keyup keydown', '#amount', function () {
        let amount = $('#amount').val() !== null ? removeCommas(
            $('#amount').val()) : 0;
        oldAmount = amount;
        if (isEdit === true) {
            calculateEditedTaxAmount();
        }
    });

    window.calculateEditedTaxAmount = function () {
        let tax1Value = ($('#tax1').val() != '') ? $('#tax1').
            find(':selected').
            text() : 0;
        let tax2Value = ($('#tax2').val() != '') ? $('#tax2').
            find(':selected').
            text() : 0;
        let totalTax = (oldAmount *
            (parseFloat(tax1Value) + parseFloat(tax2Value))) / 100;
        let totalAmountWithTax = parseFloat(oldAmount) +
            parseFloat(totalTax);
        $('#taxRate').val(totalAmountWithTax);
    };

    if (isEdit === true) {
        /*
        * The "onlyOnceOnEdit" key is used for the 1st time when the Edit screen is loaded because we have to set the tax_rate which has been
        * saved at the time of creating the expense not to calculate the same on trigger change event unless and until user changes the tax1/tax2
        * value explicitly.
        * */
        $(document).ready(function () {
            oldAmount = $('#amount').val() !== null ? removeCommas(
                $('#amount').val()) : 0;
        });

        $(document).
            on('change', '#tax1,#tax2', function (event, param = false) {
                // only calculate the tax if tax1 OR tax2 is not empty
                if ($('#tax1').val() != '' || $('#tax2').val() != '') {
                    calculateEditedTaxAmount();
                } else {
                    $('#taxRate').val(oldAmount);
                }
            });
    } else {

        $(document).
            on('change', '#tax1,#tax2', function (event, param = false) {
                // only calculate the tax if tax1 OR tax2 is not empty
                if ($('#tax1').val() != '' || $('#tax2').val() != '') {
                    let tax1Value = ($('#tax1').val() != '') ? $('#tax1').
                        find(':selected').
                        text() : 0;
                    let tax2Value = ($('#tax2').val() != '') ? $('#tax2').
                        find(':selected').
                        text() : 0;
                    let totalTax = (oldAmount *
                        (parseFloat(tax1Value) + parseFloat(tax2Value))) / 100;
                    $('#taxAmount').text(addCommas(totalTax));
                    $('#taxRate').val(oldAmount);
                    checkTaxApplied();
                    $('#isTaxApplied').removeClass('d-none');

                    /*
                    * If the tax is not applied then make taxApplied checkbox unchecked.
                    * This is because we get to know that whether the tax has been applied to the amount or not.
                    * */
                    if ($('#tax1').val() == '' && $('#tax2').val() == '')
                        $('#taxApplied').prop('checked', false);
                } else {
                    $('#taxApplied').prop('checked', false);
                    $('#taxAmount').text('');
                    $('#taxRate').val('');
                    $('#isTaxApplied').addClass('d-none');
                    calculateFinalAmount();
                }
            });

        window.calculateFinalAmount = function () {
            let taxAmount = removeCommas($('#taxAmount').text()) !== undefined
                ? removeCommas($('#taxAmount').text())
                : 0;
            let finalAmount = oldAmount - taxAmount;
            $('#amount').val(addCommas(finalAmount));
            $('#taxRate').val(oldAmount);
        };

        $(document).on('change', '#taxApplied', function () {
            checkTaxApplied();
        });

        window.checkTaxApplied = function () {
            if ($('#taxApplied').prop('checked') === true) {
                calculateFinalAmount();
            } else {
                $('#amount').val(addCommas(oldAmount));
                $('#taxRate').val('');
            }
        };
    }

    $(document).on('change', '#billable', function () {
        if ($('.showBillableFields').hasClass('d-none')) {
            $('.showBillableFields').removeClass('d-none');
        } else {
            $('#autoCreateInvoice,#sendMail').prop('checked', false);
            $('.showBillableFields').addClass('d-none');
        }
    });

    window.removeCommas = function (str) {
        return str.replace(/,/g, '');
    };
});

$(document).on('mouseenter', '.expense-attachment', function () {
    $(this).find('.expense-attachment__icon').removeClass('d-none');
});

$(document).on('mouseleave', '.expense-attachment', function () {
    $(this).find('.expense-attachment__icon').addClass('d-none');
});
