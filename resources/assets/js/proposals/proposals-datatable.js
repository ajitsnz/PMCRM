'use strict';

$(document).ready(function () {
    $('#filterStatus').
        select2({
            width: '150px',
        });
});

$(document).on('change', '#filterStatus', function () {
    window.livewire.emit('filterProposalStatus', $(this).val());
});

$(document).on('mouseenter', '.livewire-card', function () {
    $(this).find('.proposal-action-btn').removeClass('d-none');
});

$(document).on('mouseleave', '.livewire-card', function () {
    $(this).find('.proposal-action-btn').addClass('d-none');
    $(this).parent().trigger('click');
});

$(document).on('click', '.delete-btn', function () {
    let proposalId = $(this).attr('data-id');
    deleteItemLiveWire(proposalUrl + '/' + proposalId, 'Proposal');
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
    $('#proposalFilterStatus').select2();
});

$(document).on('change', '#proposalFilterStatus', function () {
    window.livewire.emit('filterProposalStatus', $(this).val());
});

document.addEventListener('DOMContentLoaded', function (event) {
    Livewire.hook('message.received', (message, component) => {
        setTimeout(function () {
            $(document).find('#proposalFilterStatus').select2('destroy');
            $(document).find('#proposalFilterStatus').select2();
            $(document).find('.select2').removeClass('opacity-0');
        }, 200);
    });
});
