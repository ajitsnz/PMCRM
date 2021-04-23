'use strict';

$(document).on('click', '#btnCancel', function () {
    $('#commentContainer').summernote('code', '');
});

function addCommentSection (comment) {
    let id = comment.id;
    let icons = '';
    if (comment.added_by == authId) {
        icons = '                    <a class="user__icons del-comment d-none task-comment-delete" data-id="' +
            id + '"><i class="fas fa-trash ml-0 card-delete-icon"></i></a>\n' +
            '                    <a class="user__icons edit-comment d-none task-comment-edit" data-id="' +
            id +
            '"><i class="fas fa-edit mr-2 card-edit-icon"></i></a>\n' +
            '                    <a class="user__icons save-comment comment-save-icon-' +
            id + ' d-none task-comment-check" data-id="' + id +
            '"><i class="far fa-check-circle card-save-icon text-success font-weight-bold hand-cursor mr-2 ml-2"></i></a>\n' +
            '                    <a class="user__icons cancel-comment comment-cancel-icon-' +
            id + ' d-none task-comment-cancel" data-id="' + id +
            '"><i class="fas fa-times card-cancel-icon hand-cursor"></i></a>\n';
    }
    return '<div class="activity clearfix comments__information" id="comment__' +
        id +
        '">\n' +
        '        <div class="activity-icon">\n' +
        '            <img class="user__img profile" src="' +
        comment.user.image_url +
        '" alt="User Image" width="50" height="50">\n' +
        '            <span class="user__username">\n' +
        '            </span>\n' +
        '        </div>\n' +
        '        <div class="activity-detail col-xl-11 col-lg-10 pt-1 mb-3">' +
        '        <div class="mb-0 d-flex justify-content-between flex-wrap">' +
        '        <div class="d-flex flex-wrap align-items-center">' +
        '             <span class="font-weight-bold lead">' +
        comment.user.full_name + '</span>\n' +
        '            <span class="user__description text-job text-dark ml-2">Just now</span>\n' +
        '        </div><div>' +
        icons +
        '            </div></div>' +
        '            <div class="user__comment mt-2 comment-display comment-display-' +
        id + '" data-id="' + id + '">\n' +
        comment.description +
        '           </div>\n' +
        '           <div class="user__comment d-none comment-edit comment-edit-' +
        id + '">\n' +
        '           <div id="commentEditContainer' + id +
        '" class="quill-editor-container"></div>\n' +
        '           </div>\n' +
        '       </div>' +
        '    </div>';
}

$(document).on('click', '#btnComment', function () {
    let description = quillComment.summernote('code');
    let ownerId = $('#ownerId').val();
    let moduleId = $('#moduleId').val();

    if (quillComment.summernote('isEmpty')) {
        return false;
    }

    let commentDescription = $('<div />').
        html($('#commentContainer').summernote('code'));
    let empty = commentDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#commentContainer').summernote('isEmpty')) {
        $('#commentContainer').val('');
    } else if (empty) {
        displayErrorMessage('Comment field is not contain only white space');
        let loadingButton = $(this);
        loadingButton.button('reset');
        return false;
    }

    let loadingButton = $(this);
    loadingButton.button('loading');
    $.ajax({
        url: commentSaveUrl,
        type: 'post',
        data: {
            'description': description,
            'owner_id': ownerId,
            'module_id': moduleId,
        },
        success: function (result) {
            if (result.success) {
                processAddCommentResponse(result.data);
            }
            loadingButton.button('reset');
        },
        error: function (result) {
            loadingButton.button('reset');
            printErrorMessage('#taskValidationErrorsBox', result);
        },
    });
});

$(document).on('click', '.del-comment', function (event) {
    let commentId = $(this).data('id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to delete this "Comment" ?',
            type: 'warning',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
        },
        function () {
            $.ajax({
                url: commentUrl + commentId,
                type: 'DELETE',
                success: function (result) {
                    if (result.success) {
                        processDeleteCommentResponse(commentId, ownerId);
                    }
                    swal({
                        title: 'Deleted!',
                        text: 'Comment has been deleted.',
                        type: 'success',
                        confirmButtonColor: '#6777ef',
                        timer: 2000,
                    });
                },
                error: function (data) {
                    swal({
                        title: '',
                        text: data.responseJSON.message,
                        type: 'error',
                        timer: 5000,
                    });
                },
            });
        });
});

function processAddCommentResponse (result) {
    let commentDiv = addCommentSection(result);
    $('.comments .activities').prepend(commentDiv);
    quillComment.summernote('code', '');  // to empty content of the SummernoteEditor instance/container
    $('.no_comments').hide();
}

function processDeleteCommentResponse (commentId, ownerId) {
    let commentDiv = 'comment__' + commentId;
    $('#' + commentDiv).remove();

    $.ajax({
        url: ownerUrl + '/' + ownerId + '/comments-count',
        type: 'GET',
        success: function (result) {
            if (result.data == 0) {
                $('.no_comments').show();
                $('.no_comments').removeClass('d-none');
            }
        },
    });
}

function processUpdateCommentResponse (commentId, description) {
    $('.comment-display-' + commentId).html(description).removeClass('d-none');
    $('.comment-edit-' + commentId).addClass('d-none');
    $('.comment-save-icon-' + commentId).addClass('d-none');
    $('.comment-cancel-icon-' + commentId).addClass('d-none');
}

let quillCommentEdit = [];
$(document).on('click', '.comment-display,.edit-comment', function () {
    let commentId = $(this).data('id');

    $(document).find('[class*=\'comment-display-\']').removeClass('d-none');
    $(document).find('[class*=\'comment-edit-\']').addClass('d-none');
    $(document).find('[class*=\'comment-save-icon-\']').addClass('d-none');
    $(document).
        find('[class*=\'comment-cancel-icon-\']').
        addClass('d-none');

    $('.comment-display-' + commentId).addClass('d-none');
    if ($('#commentEditContainer' + commentId).html() === '') {
        setCommentEditData(commentId);
    } else {
        let commentData = $.trim($('.comment-display-' + commentId).html());
        quillCommentEdit[commentId].summernote('code', '');  // to empty content of the SummernoteEditor instance/container
        quillCommentEdit[commentId].summernote('code', commentData);  // to set the HTML content to SummernoteEditor instance/container
    }

    $('.comment-edit-' + commentId).removeClass('d-none');
    $('.comment-save-icon-' + commentId).removeClass('d-none');
    $('.comment-cancel-icon-' + commentId).removeClass('d-none');
});

/*
   - This method will create separate SummernoteEditor instance (but only once, then after it will use the existing created one) when some
   one will edit the comment.

   - After creating the instance, it will set the data back to the editor in order to edit the comment.
 */
window.setCommentEditData = function (commentId) {
    // create new SummernoteEditor instance
    quillCommentEdit[commentId] = $('#commentEditContainer' + commentId).
        summernote({
            placeholder: 'Add Comment...',
            minHeight: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['paragraph']]],
        });

    let commentData = $.trim($('.comment-display-' + commentId).html());

    quillCommentEdit[commentId].summernote('code', commentData);  // to set the HTML content to SummernoteEditor instance/container
};

$(document).on('click', '.cancel-comment', function (event) {
    let commentId = $(this).data('id');
    $(this).addClass('d-none');
    $('.comment-display-' + commentId).removeClass('d-none');
    $('.comment-edit-' + commentId).addClass('d-none');
    $('.comment-save-icon-' + commentId).addClass('d-none');
});

$(document).on('click', '.save-comment', function (event) {
    let commentId = $(this).data('id');
    let description = quillCommentEdit[commentId].summernote('code');  // retrieve the HTML content from the Summernotecontainer
    let ownerId = $('#ownerId').val();
    let moduleId = $('#moduleId').val();

    // this will check whether the SummernoteEditor has empty and doesn't have any content entered in it
    if (quillCommentEdit[commentId].summernote('isEmpty')) {
        return false;
    }

    let $editComment = $('<div />').
        html($('#commentEditContainer' + commentId).summernote('code'));
    let empty = $editComment.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#commentEditContainer' + commentId).summernote('isEmpty')) {
        $('#commentEditContainer' + commentId).val('');
    } else if (empty) {
        displayErrorMessage('Comment field is not contain only white space');
        let loadingButton = $(this);
        loadingButton.button('reset');
        return false;
    }

    $.ajax({
        url: commentUrl + commentId,
        type: 'put',
        data: {
            'description': description,
            'owner_id': ownerId,
            'module_id': moduleId,
        },
        success: function (result) {
            if (result.success) {
                processUpdateCommentResponse(commentId, description);
            }
        },
        error: function (result) {
            printErrorMessage('#taskValidationErrorsBox', result);
        },
    });
});

$(document).on('mouseenter', '.comments__information', function () {
    $(this).find('.del-comment').removeClass('d-none');
    $(this).find('.edit-comment').removeClass('d-none');
});

$(document).on('mouseleave', '.comments__information', function () {
    $(this).find('.del-comment').addClass('d-none');
    $(this).find('.edit-comment').addClass('d-none');
});

// Summernote editor initialization scripts
let quillComment = $('#commentContainer').summernote({
    placeholder: 'Add Comment...',
    minHeight: 200,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['para', ['paragraph']]],
});
