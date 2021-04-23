'use strict';

$(document).ready(function () {
    $('#expenseCategory').select2({
        width: '210px',
    });
});

$(document).on('mouseenter', '.expense-card', function () {
    $(this).find('.expense-action-btn').removeClass('d-none');
});

$(document).on('mouseleave', '.expense-card', function () {
    $(this).find('.expense-action-btn').addClass('d-none');
    $(this).parent().trigger('click');
});

$(document).on('change', '#expenseCategory', function () {
    window.livewire.emit('filterCategory', $(this).val());
});

$(document).on('click', '.delete-btn', function () {
    let expenseId = $(this).attr('data-id');
    deleteItemLiveWire(expenseUrl + '/' + expenseId, 'Expense');
});
