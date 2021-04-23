'use strict';

$(document).ready(function () {

    $('#filter_group').
        select2({
            width: '200px',
        });

    $('#filterInternalArticle').select2({
        width: '185px',
    });

    $('#filterDisabledArticle').select2({
        width: '150px',
    });
    
    $('#filterArticleGroup').select2();

});

$(document).on('mouseenter', '.livewire-card', function () {
    $(this).find('.action-dropdown').removeClass('d-none');
});

$(document).on('mouseleave', '.livewire-card', function () {
    $(this).find('.action-dropdown').addClass('d-none');
    $(this).parent().trigger('click');
});

$(document).on('click', '.delete-btn', function (event) {
    let articleId = $(event.currentTarget).data('id');
    deleteItemLivewire('deleteArticle', articleId, 'Article');
});

window.addEventListener('deleted', function (data) {
    livewireDeleteEventListener(data, 'Article');
});


$(document).on('change', '#filterInternalArticle', function () {
    window.livewire.emit('filterInternalArticle', $(this).val());
});

$(document).on('change', '#filterDisabledArticle', function () {
    window.livewire.emit('filterDisabledArticle', $(this).val());
});

$(document).on('change', '#filterArticleGroup', function () {
    window.livewire.emit('filterArticleGroup', $(this).val());
});

// change event for internal article value
$(document).on('change', '.internalArticle', function (event) {
    let articleId = $(event.currentTarget).data('id');
    updateInternalArticle(articleId);
});

// change event for disabled article value
$(document).on('change', '.articleDisabled', function (event) {
    let articleId = $(event.currentTarget).attr('data-id');
    updateDisabledArticle(articleId);
});

window.updateInternalArticle = function (id) {
    $.ajax({
        url: articleUrl + '/' + id + '/active-deactive-article',
        method: 'post',
        cache: false,
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                tbl.ajax.reload(null, false);
            }
        },
        complete: function () {
            stopLoader();
        },
    });
};

window.updateDisabledArticle = function (id) {
    $.ajax({
        url: articleUrl + '/' + id + '/active-deactive-disabled',
        method: 'post',
        cache: false,
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                window.livewire.emit('refresh');
            }
        },
        error: function (result) {
            manageAjaxErrors(result);
            window.livewire.emit('refresh');
        },
        complete: function () {
            stopLoader();
        },
    })
};
