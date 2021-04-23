'use strict';

$(document).ready(function () {

    $('#goalTypeId,#editGoalTypeId').select2({ width: '100%' });

    $(document).on('submit', '#createGoal, #editGoal', function () {
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');
        if ($('#error-msg').text() !== '') {
            return false;
        }

        let description = $('<div />').
            html($('#goalDescription').summernote('code'));
        let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

        if ($('#goalDescription').summernote('isEmpty')) {
            $('#goalDescription').val('');
        } else if (empty) {
            displayErrorMessage(
                'Description field is not contain only white space');
            let loadingButton = jQuery(this).find('#btnSave');
            loadingButton.button('reset');
            return false;
        }

    });

    $('.startDatepicker').datetimepicker({
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

    $('.endDatepicker').datetimepicker({
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

    $('.startDatepicker, .endDatepicker').on('dp.show', function () {
        matchWindowScreenPixels(
            {
                startDatepicker: '.startDatepicker',
                endDatepicker: '.endDatepicker',
            },
            'goal');
    });

    setTimeout(function () {
        if (typeof editData == 'undefined')
            $('.endDatepicker').
                data('DateTimePicker').
                minDate(moment().millisecond(0).second(0).minute(0).hour(0));
        else
            $('.endDatepicker').
                data('DateTimePicker').
                minDate($('.endDatepicker').val());

    }, 1000);

    $('.staffMember').select2({
        width: '100%',
        placeholder: '   Select Members',
    });
});
