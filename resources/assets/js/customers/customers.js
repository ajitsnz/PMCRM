'use strict';

$(document).on('click', '.customer-delete-btn', function (event) {
    let customerId = $(event.currentTarget).data('id');
    let alertMessage = '<div class="alert alert-warning swal__alert">\n' +
        '<strong class="swal__text-warning">' + deleteCustomerConfirm +
        '</strong><div class="swal__text-message">' + byDeleteThisCustomer +
        '</div></div>';

    deleteItemInputConfirmation(customerUrl + '/' + customerId,
        'Customer', alertMessage);
});

function deleteItemAjax (url, header, callFunction = null) {
    $.ajax({
        url: url,
        type: 'DELETE',
        dataType: 'json',
        success: function (obj) {
            if (obj.success) {
                window.livewire.emit('refresh');
            }
            swal({
                title: 'Deleted!',
                text: header + ' has been deleted.',
                type: 'success',
                confirmButtonColor: '#6777ef',
                timer: 2000,
            });
            if (callFunction) {
                eval(callFunction);
            }
        },
        error: function (data) {
            swal({
                title: '',
                text: data.responseJSON.message,
                type: 'error',
                confirmButtonColor: '#6777ef',
                timer: 5000,
            });
        },
    });
}

window.deleteItemInputConfirmation = function (
    url, header, alertMessage, callFunction = null) {
    swal({
            type: 'input',
            inputPlaceholder: deleteConfirm + ' "' + deleteWord + '" ' +
                toTypeDelete + ' ' + header + '.',
            title: deleteHeading + ' !',
            text: alertMessage,
            html: true,
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            cancelButtonText: noMessages,
            confirmButtonText: yesMessages,
            imageUrl: baseUrl + 'img/warning.png',
        },
        function (inputVal) {
            if (inputVal === false) {
                return false;
            }
            if (inputVal == '' || inputVal.toLowerCase() != 'delete') {
                swal.showInputError(
                    'Please type "delete" to delete this ' + header + '.');
                $('.sa-input-error').css('top', '23px!important');
                $(document).find('.sweet-alert.show-input :input').val('');
                return false;
            }
            if (inputVal.toLowerCase() === 'delete') {
                deleteItemAjax(url, header, callFunction = null);
            }
        });
};
