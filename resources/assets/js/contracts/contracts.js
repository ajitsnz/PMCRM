'use strict';

$(document).ready(function () {
    $('#filterType').
        select2({
            width: '180px',
        });
});

$(document).on('change', '#filterType', function () {
    window.livewire.emit('filterType', $(this).val());
});

$(document).on('click', '.delete-btn', function () {
    let contractId = $(this).attr('data-id');
    deleteItemLiveWire(contractUrl + '/' + contractId, 'Contract');
});

$(document).on('mouseenter', '.livewire-card', function () {
    $(this).find('.action-dropdown').removeClass('d-none');
});

$(document).on('mouseleave', '.livewire-card', function () {
    $(this).find('.action-dropdown').addClass('d-none');
    $(this).parent().trigger('click');
});
