'use strict';

$(document).ready(function () {

    if (!!document.createRange) {
        document.getSelection().removeAllRanges();
    }

    $('#emailMessage').summernote({
        dialogsInBody: true,
        minHeight: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['table', ['table']],
            ['misc', ['undo', 'redo']],
            ['height', ['height']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview', 'help']],
        ],
        spellCheck: true,
    });

    $(document).on('click', '.fieldText', function (e) {
        let selection = document.getSelection();
        let cursorPos = selection.anchorOffset;
        let oldContent = selection.anchorNode.nodeValue;
        let toInsert = $(this).text();
        let newContent = oldContent.substring(0, cursorPos) + toInsert +
            oldContent.substring(cursorPos);
        selection.anchorNode.nodeValue = newContent;
        let html = $('#emailMessage').summernote('code');
        $('#emailMessage').summernote('code', html);
    });
});
