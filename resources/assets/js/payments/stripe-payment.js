'use strict';

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    $(document).on('click', '#invoiceStripePayment', function () {
        let payloadData = {
            invoiceId: invoiceID,
        };
        $(this).
            html(
                '<div class="spinner-border spinner-border-sm" role="status">\n' +
                '<span class="sr-only">Loading...</span>\n' + '</div>' + '  ' +
                'Loading...');

        $(this).addClass('disabled');

        $.post(invoiceStripePaymentUrl, payloadData).done((result) => {
            let sessionId = result.data.sessionId;
            stripe.redirectToCheckout({
                sessionId: sessionId,
            }).then(function (result) {
                manageAjaxErrors(result);
            });
        }).catch(error => {
            manageAjaxErrors(error);
            $(this).removeClass('disabled');
        });
    });
});
