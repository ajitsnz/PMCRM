'use strict';

$(document).on('mouseenter', '.ticket-attachment', function () {
    $(this).find('.ticket-attachment__icon').removeClass('d-none');
});

$(document).on('mouseleave', '.ticket-attachment', function () {
    $(this).find('.ticket-attachment__icon').addClass('d-none');
});
