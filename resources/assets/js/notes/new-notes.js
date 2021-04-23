'use strict';

$(document).on('click', '#btnCancel', function () {
    $('#noteContainer').summernote('code', '');
});

function addNoteSection (note) {
    let id = note.id;
    let icons = '';
    if (note.added_by == authId) {
        icons = '                    <a class="user__icons del-note d-none task-comment-delete" data-id="' +
            id + '"><i class="fas fa-trash ml-0 card-delete-icon"></i></a>\n' +
            '                    <a class="user__icons edit-note d-none task-comment-edit" data-id="' +
            id +
            '"><i class="fas fa-edit mr-2 card-edit-icon"></i></a>\n' +
            '                    <a class="user__icons save-note comment-save-icon-' +
            id + ' d-none task-comment-check" data-id="' + id +
            '"><i class="far fa-check-circle card-save-icon text-success font-weight-bold hand-cursor mr-2 ml-2"></i></a>\n' +
            '                    <a class="user__icons cancel-note comment-cancel-icon-' +
            id + ' d-none task-comment-cancel" data-id="' + id +
            '"><i class="fas fa-times card-cancel-icon hand-cursor"></i></a>\n';
    }
    return '<div class="activity clearfix notes__information" id="note__' +
        id +
        '">\n' +
        '        <div class="activity-icon">\n' +
        '            <img class="user__img profile" src="' +
        note.user.image_url +
        '" alt="User Image" width="50" height="50">\n' +
        '            <span class="user__username">\n' +
        '            </span>\n' +
        '        </div>\n' +
        '        <div class="activity-detail col-xl-11 col-lg-10 pt-1 mb-3">' +
        '        <div class="mb-0 d-flex justify-content-between flex-wrap">' +
        '        <div class="d-flex flex-wrap align-items-center">' +
        '             <span class="font-weight-bold lead">' +
        note.user.full_name + '</span>\n' +
        '            <span class="user__description text-job text-dark ml-2">Just now</span>\n' +
        '        </div><div>' +
        icons +
        '            </div></div>' +
        '            <div class="user__comment mt-2 note-display comment-display-' +
        id + '" data-id="' + id + '">\n' +
        note.note +
        '           </div>\n' +
        '           <div class="user__comment d-none note-edit comment-edit-' +
        id + '">\n' +
        '           <div id="noteEditContainer' + id +
        '" class="quill-editor-container"></div>\n' +
        '           </div>\n' +
        '       </div>' +
        '    </div>';
}

$(document).on('click', '#btnNote', function () {
    let note = quillComment.summernote('code');
    let ownerId = $('#ownerId').val();
    let moduleId = $('#moduleId').val();

    if (quillComment.summernote('isEmpty')) {
        return false;
    }

    let noteDescription = $('<div />').
        html($('#noteContainer').summernote('code'));
    let empty = noteDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#noteContainer').summernote('isEmpty')) {
        $('#noteContainer').val('');
    } else if (empty) {
        displayErrorMessage('Note field is not contain only white space');
        let loadingButton = $(this);
        loadingButton.button('reset');
        return false;
    }

    let loadingButton = $(this);
    loadingButton.button('loading');
    $.ajax({
        url: noteSaveUrl,
        type: 'post',
        data: {
            'note': note,
            'owner_id': ownerId,
            'module_id': moduleId,
        },
        success: function (result) {
            if (result.success) {
                processAddNoteResponse(result.data);
            }
            loadingButton.button('reset');
        },
        error: function (result) {
            loadingButton.button('reset');
            printErrorMessage('#taskValidationErrorsBox', result);
        },
    });
});

$(document).on('click', '.del-note', function () {
    let noteId = $(this).data('id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to delete this "Note" ?',
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
                url: noteUrl + noteId,
                type: 'DELETE',
                success: function (result) {
                    if (result.success) {
                        processDeleteNoteResponse(noteId, ownerId);
                    }
                    swal({
                        title: 'Deleted!',
                        text: 'Note has been deleted.',
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

function processAddNoteResponse (result) {
    let noteDiv = addNoteSection(result);
    $('.notes .activities').prepend(noteDiv);
    quillComment.summernote('code', '');  // to empty content of the SummernoteEditor instance/container
    $('.no_notes').hide();
}

function processDeleteNoteResponse (noteId, ownerId) {
    let noteDiv = 'note__' + noteId;
    $('#' + noteDiv).remove();

    $.ajax({
        url: ownerUrl + '/' + ownerId + '/notes' + '/notes-count',
        type: 'GET',
        success: function (result) {
            if (result.data == 0) {
                $('.no_notes').show();
                $('.no_notes').removeClass('d-none');
            }
        },
    });
}

function processUpdateNoteResponse (noteId, note) {
    $('.comment-display-' + noteId).html(note).removeClass('d-none');
    $('.comment-edit-' + noteId).addClass('d-none');
    $('.comment-save-icon-' + noteId).addClass('d-none');
    $('.comment-cancel-icon-' + noteId).addClass('d-none');
}

let quillCommentEdit = [];
$(document).on('click', '.note-display,.edit-note', function () {
    let noteId = $(this).data('id');

    $(document).find('[class*=\'comment-display-\']').removeClass('d-none');
    $(document).find('[class*=\'comment-edit-\']').addClass('d-none');
    $(document).find('[class*=\'comment-save-icon-\']').addClass('d-none');
    $(document).
        find('[class*=\'comment-cancel-icon-\']').
        addClass('d-none');

    $('.comment-display-' + noteId).addClass('d-none');
    if ($('#noteEditContainer' + noteId).html() === '') {
        setNoteEditData(noteId);
    } else {
        let noteData = $.trim($('.comment-display-' + noteId).html());
        quillCommentEdit[noteId].summernote('code', '');  // to empty content of the SummernoteEditor instance/container
        quillCommentEdit[noteId].summernote('code', noteData);  // to set the HTML content to SummernoteEditor instance/container
    }

    $('.comment-edit-' + noteId).removeClass('d-none');
    $('.comment-save-icon-' + noteId).removeClass('d-none');
    $('.comment-cancel-icon-' + noteId).removeClass('d-none');
});

/*
   - This method will create separate SummernoteEditor instance (but only once, then after it will use the existing created one) when some
   one will edit the comment.

   - After creating the instance, it will set the data back to the editor in order to edit the comment.
 */
window.setNoteEditData = function (noteId) {
    // create new SummernoteEditor instance
    quillCommentEdit[noteId] = $('#noteEditContainer' + noteId).
        summernote({
            placeholder: 'Add Note...',
            minHeight: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['paragraph']]],
        });

    let noteData = $.trim($('.comment-display-' + noteId).html());

    quillCommentEdit[noteId].summernote('code', noteData);  // to set the HTML content to SummernoteEditor instance/container
};

$(document).on('click', '.cancel-note', function () {
    let noteId = $(this).data('id');
    $(this).addClass('d-none');
    $('.comment-display-' + noteId).removeClass('d-none');
    $('.comment-edit-' + noteId).addClass('d-none');
    $('.comment-save-icon-' + noteId).addClass('d-none');
});

$(document).on('click', '.save-note', function () {
    let noteId = $(this).data('id');
    let note = quillCommentEdit[noteId].summernote('code');  // retrieve the HTML content from the SummerNoteContainer
    let ownerId = $('#ownerId').val();
    let moduleId = $('#moduleId').val();

    // this will check whether the SummernoteEditor has empty and doesn't have any content entered in it
    if (quillCommentEdit[noteId].summernote('isEmpty')) {
        return false;
    }

    let $editNote = $('<div />').
        html($('#noteEditContainer' + noteId).summernote('code'));
    let empty = $editNote.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#noteEditContainer' + noteId).summernote('isEmpty')) {
        $('#noteEditContainer' + noteId).val('');
    } else if (empty) {
        displayErrorMessage('Note field is not contain only white space');
        let loadingButton = $(this);
        loadingButton.button('reset');
        return false;
    }

    $.ajax({
        url: noteUrl + noteId,
        type: 'put',
        data: {
            'note': note,
            'owner_id': ownerId,
            'module_id': moduleId,
        },
        success: function (result) {
            if (result.success) {
                processUpdateNoteResponse(noteId, note);
            }
        },
        error: function (result) {
            printErrorMessage('#taskValidationErrorsBox', result);
        },
    });
});

$(document).on('mouseenter', '.notes__information', function () {
    $(this).find('.del-note').removeClass('d-none');
    $(this).find('.edit-note').removeClass('d-none');
});

$(document).on('mouseleave', '.notes__information', function () {
    $(this).find('.del-note').addClass('d-none');
    $(this).find('.edit-note').addClass('d-none');
});

// Summernote editor initialization scripts
let quillComment = $('#noteContainer').summernote({
    placeholder: 'Add Note...',
    minHeight: 200,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['para', ['paragraph']]],
});
