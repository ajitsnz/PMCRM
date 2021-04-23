'use strict';

let containers = [];
let boardCount = document.getElementsByClassName('board').length;

for (let i = 0; i < boardCount; i++) {
    containers.push(document.querySelector('.board-' + i));
}

let id;
let drake = dragula({
    containers: containers,
    revertOnSpill: true,
    direction: 'vertical',
}).on('drag', function (el) {
    el.className = el.className.replace('ex-moved', '');
}).on('drop', function (el, container) {
    let board = $(container);
    el.className += ' ex-moved';
    id = $('.ex-moved').data('id');
    let boardStatus = $(container).data('board-status');
    board.parent().find('.infy-loader').fadeIn();
    $.ajax({
        url: ticketUrl + '/' + id + '/status/' + boardStatus,
        type: 'PUT',
        cache: false,
        complete: function () {
            board.parent().find('.infy-loader').fadeOut();
        },
    });
}).on('over', function (el, container) {
    container.className += ' ex-over';
}).on('out', function (el, container) {
    container.className = container.className.replace('ex-over', '');
});

$(document).ready(function () {
    let containers = [
        document.querySelector('.flex-nowrap'),
    ];

    $('.board').each(function (index, ele) {
        containers.push(document.querySelector('.board-' + index));
    });

    let scroll = autoScroll(containers, {
        margin: 200,
        autoScroll: function () {
            return this.down && drake.dragging;
        },
    });
});
