'use strict';

$(document).on('click', 'a', function (event) {
    event.stopPropagation();
});

$(document).on('click', '#markAsSent, #markAsCancelled, #unmarkAsCancelled',
    function () {
        let paymentStatus = $(this).data('status');

        $.ajax({
            url: changeStatus,
            type: 'put',
            data: { 'paymentStatus': paymentStatus },
            success: function (result) {
                if (result.success) {
                    let invoiceId = result.data;
                        window.location.href = invoiceId;
                        displaySuccessMessage(result.message);
                    }
                },
                error: function (result) {
                    displayErrorMessage(result.responseJSON.message);
                },
            });
        });
