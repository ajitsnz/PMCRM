'use strict';

$(document).ready(function () {
    $('#paymentStatus').select2({
        width: '150px',
    });
});


$(document).on('change', '#paymentStatus', function () {
    window.livewire.emit('filterPaymentStatus', $(this).val());
});

