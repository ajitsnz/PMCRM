'use strict';

$(document).on('click', 'a', function (event) {
    event.stopPropagation();
});

$(document).
    on('click',
        '#markAsDraft, #markAsSend ,#markAsOpen,#markAsRevised,#markAsDeclined,#markAsAccepted',
        function () {
            let status = $(this).data('status');

            $.ajax({
                url: changeStatus,
                type: 'put',
                data: { 'status': status },
                success: function (result) {
                    if (result.success) {
                        window.location.href = proposalId;
                        displaySuccessMessage(result.message);
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    });

//=========== Convert Proposal To Invoice ===================

$(document).on('click', '#convertToInvoice', function () {
    $.ajax({
        url: invoiceSaveUrl,
        type: 'post',
        success: function (result) {
            if (result.success) {
                let invoiceId = result.data.id;
                window.location.href = invoiceUrl + '/' + invoiceId;
                displaySuccessMessage(result.message);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

//============= Convert Proposal To Estimate ==============//

$(document).on('click', '#convertToEstimate', function () {
    $.ajax({
        url: estimateSaveUrl,
        type: 'post',
        success: function (result) {
            if (result.success) {
                let estimateId = result.data.id;
                window.location.href = estimateUrl + '/' + estimateId;
                displaySuccessMessage(result.message);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});
