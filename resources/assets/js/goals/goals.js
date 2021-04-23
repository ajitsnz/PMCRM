'use strict';

$(document).ready(function () {
    $('#goalTypeId').
        select2({
            width: '180px',
        });
});

$(document).on('click', '.delete-btn', function (event) {
    let goalId = $(event.currentTarget).data('id');
    deleteItemLiveWire(goalUrl + '/' + goalId,  'Goal');
});

$(document).on('mouseenter', '.livewire-card', function () {
    $(this).find('.action-dropdown').removeClass('d-none');
});

$(document).on('mouseleave', '.livewire-card', function () {
    $(this).find('.action-dropdown').addClass('d-none');
    $(this).parent().trigger('click');
});

$(document).on('change', '#goalTypeId', function () {
    window.livewire.emit('filterStatus', $(this).val());
});
