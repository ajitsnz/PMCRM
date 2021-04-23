'use strict';

$(document).ready(function () {
    $('#paymentMode').
        select2({
            width: '100%',
        });

    $('#paymentDate').datetimepicker({
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

    $(document).on('click', '#addPayment', function (event) {
        let invoiceId = $(event.currentTarget).data('id');
        renderData(invoiceId);
    });

    $('#note').summernote({
        dialogsInBody: true,
        minHeight: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]],
    });

    window.renderData = function (id) {
        $.ajax({
            url: addPaymentUrl,
            type: 'GET',
            data: {
                invoice_id: id,
            },
            success: function (result) {
                if (result.success) {
                    $('#paymentOwnerId').val(result.data.id);
                    $('#paymentAmount').
                        val(getFormattedPrice(result.data.amount));
                    $('#paymentDate').val(format(result.data.date,
                        'YYYY-MM-DD HH:mm:ss'));
                    $('#addPaymentModal').appendTo('body').modal('show');
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    };

    $(document).on('submit', '#addNewPaymentForm', function (e) {
        e.preventDefault();
        processingBtn('#addNewPaymentForm', '#btnPaymentSave', 'loading');
        $.ajax({
            url: paymentSaveUrl,
            type: 'POST',
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    $('#addPaymentModal').modal('hide');
                    $('#paymentsTbl').DataTable().ajax.reload(null, true);
                    window.location.href = invoiceUrl + '/' + invoiceId;
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                processingBtn('#addNewPaymentForm', '#btnPaymentSave');
            },
        });
    });
});

$('#addPaymentModal').on('show.bs.modal', function () {
    $('.note-toolbar-wrapper').removeAttr('style');
    $('.note-toolbar').removeAttr('style');
});
