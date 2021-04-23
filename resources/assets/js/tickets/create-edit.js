'use strict';

$(document).ready(function () {

    $(document).on('submit', '#createTicket, #editTicket', function () {
        let loadingButton = jQuery(this).find('#btnSave');
        loadingButton.button('loading');
        if ($('#error-msg').text() !== '') {
            return false;
        }

        let description = $('<div />').
            html($('#ticketBody').summernote('code'));
        let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

        if ($('#ticketBody').summernote('isEmpty')) {
            $('#ticketBody').val('');
        } else if (empty) {
            displayErrorMessage(
                'Description field is not contain only white space');
            let loadingButton = jQuery(this).find('#btnSave');
            loadingButton.button('reset');
            return false;
        }
    });

    $('#tagId').select2({
        width: '100%',
        placeholder: '  Select Tags',
    });

    $('#priorityId').select2({
        width: '100%',
    });

    $('#serviceId').select2({
        width: '100%',
    });

    $('#contactId,#assignToId,#departmentId,#predefinedReplyId').select2({
        width: '100%',
    });

    $('#ticketStatusId').select2({
        width: '100%',
        placeholder: 'Select Status',
    });

    $('.ticketBody').summernote({
        dialogsInBody: true,
        minHeight: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']],
        ],
    });

    $(document).on('click', '#ticketContactBtn', function () {
        if ($('#contactCol').hasClass('d-none')) {
            $('#ticketContact').text('Ticket without Contact');
            $('#ticketContactIcon').attr('class', 'fas fa-envelope');
            $('#contactCol').removeClass('d-none');
            $('#nameCol').addClass('d-none');
        } else {
            $('#ticketContact').text('Ticket to Contact');
            $('#ticketContactIcon').attr('class', 'fas fa-user');
            $('#contactCol').addClass('d-none');
            $('#nameCol').removeClass('d-none');
        }
    });

    $(document).on('change', '#predefinedReplyId', function () {
        let predefinedReplyId = $(this).val();
        if (predefinedReplyId !== '') {
            $.ajax({
                url: predefinedReplyUrl + predefinedReplyId,
                type: 'GET',
                success: function (result) {
                    $('.ticketBody').summernote('code', result);
                },
            });
        } else
            $('.ticketBody').summernote('code', '');
    });

    $(document).on('mouseenter', '.ticket-attachment', function () {
        $(this).find('.attachment-delete').removeClass('d-none');
    });

    $(document).on('mouseleave', '.ticket-attachment', function () {
        $(this).find('.attachment-delete').addClass('d-none');
    });

    $(document).on('click', '.attachment-delete', function (event) {
        let ticketAttachmentId = $(event.currentTarget).data('id');
        swal({
                title: 'Delete !',
                text: 'Are you sure want to delete this "Attachment" ?',
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
                    url: ticketAttachmentUrl,
                    type: 'DELETE',
                    dataType: 'json',
                    data: { mediaId: ticketAttachmentId },
                    success: function (obj) {
                        if (obj.success) {
                            window.location.reload();
                        }
                        swal({
                            title: 'Deleted!',
                            text: 'Attachment has been deleted.',
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
                            confirmButtonColor: '#6777ef',
                            timer: 5000,
                        });
                    },
                });
            });
    });

    document.querySelector('#attachment').
        addEventListener('change', handleFileSelect, false);
    let selDiv = document.querySelector('#attachmentFileSection');

    function handleFileSelect (e) {
        if (!e.target.files || !window.FileReader) return;

        selDiv.innerHTML = '';
        let files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            let f = files[i];
            let reader = new FileReader();
            reader.onload = function (e) {
                if (f.type.match('image*')) {
                    let html = '<img class=\'img-thumbnail thumbnail-preview ticket-attachment\' src="' +
                        e.target.result + '">';
                    selDiv.innerHTML += html;
                } else if (f.type.match('pdf*')) {
                    let html = '<img class=\'img-thumbnail thumbnail-preview ticket-attachment\' src="/assets/img/pdf_icon.png">';
                    selDiv.innerHTML += html;
                } else if (f.type.match('zip*')) {
                    let html = '<img class=\'img-thumbnail thumbnail-preview ticket-attachment\' src="/assets/img/zip_icon.png">';
                    selDiv.innerHTML += html;
                } else if (f.type.match('sheet*')) {
                    let html = '<img class=\'img-thumbnail thumbnail-preview ticket-attachment\' src="/assets/img/xlsx_icon.png">';
                    selDiv.innerHTML += html;
                } else if (f.type.match('text*')) {
                    let html = '<img class=\'img-thumbnail thumbnail-preview ticket-attachment\' src="/assets/img/txt_icon.png">';
                    selDiv.innerHTML += html;
                } else if (f.type.match('msword*')) {
                    let html = '<img class=\'img-thumbnail thumbnail-preview ticket-attachment\' src="/assets/img/doc_icon.png">';
                    selDiv.innerHTML += html;
                } else {
                    selDiv.innerHTML += f.name;
                }

            };
            reader.readAsDataURL(f);
        }
    }

    $(document).on('mouseenter', '.ticket-attachment', function () {
        $(this).find('.ticket-attachment__icon').removeClass('d-none');
    });

    $(document).on('mouseleave', '.ticket-attachment', function () {
        $(this).find('.ticket-attachment__icon').addClass('d-none');
    });

});
