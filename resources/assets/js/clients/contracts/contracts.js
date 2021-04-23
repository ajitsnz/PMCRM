'use strict';

$(document).ready(function () {
    $('#filterType').select2({
        width: '200px',
    });
});

$(document).on('change', '#filterType', function () {
    window.livewire.emit('filterType', $(this).val());
});
