'use strict';

$(document).ready(function () {
    $('#ticketStatus').select2({
        width: '150px',
    });
});

$(document).on('mouseenter', '.livewire-card', function () {
    $(this).find('.ticket-action-btn').removeClass('d-none');
});

$(document).on('mouseleave', '.livewire-card', function () {
    $(this).find('.ticket-action-btn').addClass('d-none');
    $(this).parent().trigger('click');
});

$(document).on('change', '#ticketStatus', function () {
    window.livewire.emit('filterTicketByStatus', $(this).val());
});

$(document).on('click', '.delete-btn', function () {
    let ticketId = $(this).attr('data-id');
    deleteItemLiveWire(ticketUrl + ticketId, 'Ticket');
});

document.addEventListener('livewire:load', function (event) {
    Livewire.hook('message.processed', (message, component) => {
        let $owl = $('.owl-carousel');
        $owl.trigger('destroy.owl.carousel');

        $owl.html($owl.find('.owl-stage-outer').html()).
            removeClass('owl-loaded');
        livewireLoadOwel($owl);
    });
});

$(document).ready(function () {
    $('#customerTicketStatus').select2();
});

$(document).on('change', '#customerTicketStatus', function () {
    window.livewire.emit('filterTicketByStatus', $(this).val());
});

document.addEventListener('DOMContentLoaded', function (event) {
    Livewire.hook('message.received', (message, component) => {
        setTimeout(function () {
            $(document).find('#customerTicketStatus').select2('destroy');
            $(document).find('#customerTicketStatus').select2();
            $(document).find('.select2').removeClass('opacity-0');
        }, 200);
    });
});
