'use strict';

$(document).ready(function () {

    if ($('#calculateProgressThroughTasks').prop('checked') == true) {
        $('#projectProgress').attr('disabled', true);
        $('#percentageId').hide();
    } else {
        $('#projectProgress').removeAttr('disabled');
        $('#percentageId').show();
    }

    $(document).on('submit', '#createProject, #editProject', function () {
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');
        $('#btnSave').attr('disabled', true);
        if ($('#error-msg').text() !== '') {
            return false;
        }

        let description = $('<div />').
            html($('#projectDescription').summernote('code'));
        let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

        if ($('#projectDescription').summernote('isEmpty')) {
            $('#projectDescription').val('');
        } else if (empty) {
            displayErrorMessage(
                'Description field is not contain only white space');
            let loadingButton = jQuery(this).find('#btnSave');
            loadingButton.button('reset');
            return false;
        }

    });

    $(document).on('change', '#calculateProgressThroughTasks', function () {
        if ($(this).prop('checked') == true) {
            $('#projectProgress').attr('disabled', true);
            $('#percentageId').hide();
        } else {
            $('#projectProgress').removeAttr('disabled');
            $('#percentageId').show();
        }
    });

    $('#startDate').datetimepicker({
        format: 'YYYY-MM-DD',
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

    $('#deadline').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false,
        sideBySide: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom',
        },
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });

    $('#startDate, #deadline').on('dp.show', function () {
        matchWindowScreenPixels(
            { startDate: '#startDate', deadline: '#deadline' },
            'pro');
    });

    setTimeout(function () {
        if (editData == true)
            $('#deadline').data('DateTimePicker').minDate($('#deadline').val());
        else
            $('#deadline').
                data('DateTimePicker').
                minDate(moment().add(1, 'day'));

    }, 1000);

    $('#customersSelectBox').select2({
        placeholder: 'Select Customer',
        width: '100%',
    });

    $('#contactsSelectBox').select2({
        placeholder: '  Select Contacts',
        width: '100%',
    });

    $('#membersSelectBox').select2({
        placeholder: '  Select Members',
        width: '100%',
    });

    $('#tablesSelectBox').select2({
        placeholder: 'Select tables',
        width: '100%',
    });

    $('#billingTypeSelectBox').select2({
        width: '100%',
        placeholder: 'Select Billing Type',
    });

    $('#statusSelectBox').select2({
        width: '100%',
        placeholder: 'Select Status',
    });

    $('#tagsSelectBox').select2({
        placeholder: '  Select Tags',
        width: '100%',
        multiple: true,
    });

    $(document).on('change', '#projectProgress', function () {
        $('.projectProgressPercentage').text($(this).val() + '%');
    });

    setTimeout(function () {
        if (editData == true) {
            if ($('#customersSelectBox').val() !== '') {
                $('#customersSelectBox').
                    val($('#customersSelectBox').val()).
                    trigger('change');
            }
        }
    }, 500);

    $(document).on('change', '#customersSelectBox', function () {
        let customerId = $(this).val();

        $.ajax({
            url: createCustomerUrl,
            data: { 'customer_id': customerId },
            type: 'post',
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    let members = result.data;
                    let options = [];
                    $.each(members, function (key, value) {
                        options += '<option value="' + key + '">' + value +
                            '</option>';
                    });

                    $('#contactsSelectBox').html(options);
                    
                    if (editData == true && !isEmpty(editContactIds)) {
                        $('#contactsSelectBox').
                            val(editContactIds).
                            trigger('change');
                    }
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    });
});
