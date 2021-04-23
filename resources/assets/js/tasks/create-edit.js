'use strict';

$(document).ready(function () {

    setTimeout(function () {

        if ($('#relatedToId').val() !== '') {
            $('#relatedToId').val($('#relatedToId').val()).trigger('change');
        }

    }, 500);

    $(document).on('submit', '#createTasks, #editTasks', function () {
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');
        if ($('#error-msg').text() !== '') {
            return false;
        }

        let description = $('<div />').
            html($('#taskDescription').summernote('code'));
        let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

        if ($('#taskDescription').summernote('isEmpty')) {
            $('#taskDescription').val('');
        } else if (empty) {
            displayErrorMessage(
                'Description field is not contain only white space');
            let loadingButton = jQuery(this).find('#btnSave');
            loadingButton.button('reset');
            return false;
        }
    });

    $('#statusId').select2({
        width: '100%',
        placeholder: 'Select Status',
    });

    $('#tagId').select2({
        width: '100%',
        placeholder: '  Select Tags',
    });

    $('#priorityId,#relatedToId,#ownerId,#memberId').select2({
        width: '100%',
    });

    $('#startDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: true,
        sideBySide: true,
        maxDate: new Date(),
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            next: 'fa fa-chevron-right',
            previous: 'fa fa-chevron-left',
        },
    });
    $('#dueDate').datetimepicker({
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
        if (editTasks == true && $('#dueDate').val() !== '') {
            $('#dueDate').data('DateTimePicker').minDate($('#dueDate').val());
        } else {
            $('#dueDate').
                data('DateTimePicker').
                minDate(moment().millisecond(0).second(0).minute(0).hour(0));
        }
    }, 1000);

    $('#taskDescription').summernote({
        minHeight: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]],
    });

    $(document).on('change', '#relatedToId', function () {
        changeOwner('#ownerId', $(this).val());
        $('#ownerLabel').
            text($(this).children('option:selected').text() + ':');
        $('#relatedToForm').slideDown();
    });

    window.changeOwner = function (selector, id) {
        $.ajax({
            url: changeOwnerUrl,
            type: 'get',
            dataType: 'json',
            data: {
                id: id,
            },
            success: function success (data) {
                $(selector).empty();
                $.each(data.data, function (i, v) {
                    let element = document.createElement('textarea');
                    element.innerHTML = v;
                    $(selector).
                        append($('<option></option>').
                            attr('value', i).
                            text(element.value));
                });
                if (editTasksOwner) {
                    $(selector).val(taskOwnerId).trigger('change.select2');
                    return true;
                }
                if ((typeof customerId != 'undefined' && typeof relatedTo !=
                    'undefined') && customerId !== '' && relatedTo ===
                    'Customer') {
                    $(selector).val(customerId).trigger('change.select2');
                    customerId = '';
                }
            },
        });
    };
});
