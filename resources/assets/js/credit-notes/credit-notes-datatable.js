'use strict';

$(document).ready(function () {
    $('#filterStatus').select2({
        width: '150px',
    });
});

$(document).on('mouseenter', '.credit-note-card', function () {
    $(this).find('.credit-note-action').removeClass('d-none');
});

$(document).on('mouseleave', '.credit-note-card', function () {
    $(this).find('.credit-note-action').addClass('d-none');
    $(this).parent().trigger('click');
});

$(document).on('change', '#filterStatus', function () {
    window.livewire.emit('statusFilter', $(this).val());
});

$(document).on('click', '.delete-btn', function (event) {
    let creditNoteId = $(this).attr('data-id');
    deleteItemLiveWire(creditNoteUrl + '/' + creditNoteId, 'Credit Note');
});

if (customerId === null) {
    document.addEventListener('livewire:load', function (event) {
        Livewire.hook('message.processed', (message, component) => {
            let $owl = $('.owl-carousel');
            $owl.trigger('destroy.owl.carousel');

            $owl.html($owl.find('.owl-stage-outer').html()).
                removeClass('owl-loaded');
            livewireLoadOwel($owl);
        });
    });
}

$(document).ready(function () {
    $('#creditNoteStatus').select2();
});

$(document).on('change', '#creditNoteStatus', function () {
    window.livewire.emit('statusFilter', $(this).val());
});

document.addEventListener('DOMContentLoaded', function (event) {
    Livewire.hook('message.received', (message, component) => {
        setTimeout(function () {
            $(document).find('#creditNoteStatus').select2('destroy');
            $(document).find('#creditNoteStatus').select2();
            $(document).find('.select2').removeClass('opacity-0');
        }, 200);
    });
});
