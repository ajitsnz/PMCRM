'use strict';

$(document).ready(function () {

    $(document).on('submit', '#addContract, #editContract', function () {
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');

        let description = $('<div />').
            html($('#contractDescription').summernote('code'));
        let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

        if ($('#contractDescription').summernote('isEmpty')) {
            $('#contractDescription').val('');
        } else if (empty) {
            displayErrorMessage(
                'Description field is not contain only white space');
            let loadingButton = jQuery(this).find('#btnSave');
            loadingButton.button('reset');
            return false;
        }
    });

    $('#contractTypeId').select2({
        width: '100%',
        placeholder: 'Select Contract Type',
    });

    $('#customer').select2({
        width: '100%',
        placeholder: 'Select Customer',
    });

    $('.price-input').trigger('input');

    $('.startDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false,
        sideBySide: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom',
        },
        maxDate: new Date(),
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });

    $('.endDate').datetimepicker({
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

    $('.startDate').on('dp.show', function () {
        matchWindowScreenPixels(
            { startDate: '.startDate' },
            'con');
    });

    $('.endDate').on('dp.show', function () {
        matchWindowScreenPixels(
            { endDate: '.endDate' },
            'con');
    });

    setTimeout(function () {
        if (typeof editData !== 'undefined' && $('.endDate').val() !== '')
            $('.endDate').data('DateTimePicker').minDate($('.endDate').val());
        else
            $('.endDate').
                data('DateTimePicker').
                minDate(moment().millisecond(0).second(0).minute(0).hour(0));

    }, 1000);

});
