'use strict';

$(document).ready(function () {
    $('#proposalStatus').select2({
        width: '150px',
    });
});

$(document).on('change', '#proposalStatus', function () {
    window.livewire.emit('filterProposalStatus', $(this).val());
});
