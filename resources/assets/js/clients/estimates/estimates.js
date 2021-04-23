'use strict';

$(document).ready(function () {
    $('#estimateStatus').select2({
        width: '150px',
    });
});

$(document).on('change', '#estimateStatus', function () {
    window.livewire.emit('filterStatus', $(this).val());
});
