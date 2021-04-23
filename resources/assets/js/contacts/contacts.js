'use strict';

$(document).ready(function () {
    $('#isEnableId').select2({
        width: '150px',
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let contactId = $(event.currentTarget).attr('data-id');
    let alertMessage = '<div class="alert alert-warning swal__alert">\n' +
        '<strong class="swal__text-warning">' + deleteContactConfirm +
        '</strong><div class="swal__text-message">' + byDeleteThisContact +
        '</div></div>';

    swal({
            type: 'input',
            inputPlaceholder: deleteConfirm + ' "' + deleteWord + '" ' +
                toTypeDelete + 'Contact',
            title: deleteHeading + ' !',
            text: alertMessage,
            html: true,
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            cancelButtonText: noMessages,
            confirmButtonText: yesMessages,
            imageUrl: baseUrl + 'img/warning.png',
        },
        function (inputVal) {
            if (inputVal === false) {
                return false;
            }
            if (inputVal == '' || inputVal.toLowerCase() != 'delete') {
                swal.showInputError(
                    'Please type "delete" to delete this Contact');
                $('.sa-input-error').css('top', '23px!important');
                $(document).find('.sweet-alert.show-input :input').val('');
                return false;
            }
            if (inputVal.toLowerCase() === 'delete') {
                window.livewire.emit('deleteContact', contactId);
            }
        });
});

window.addEventListener('deleted', function (data) {
    livewireDeleteEventListener(data, 'Contact');
});

window.addEventListener('manageError', function (error) {
    if (error.type == 'manageError') {
        livewireDeleteErrorEventListener(error.detail);
    }
});

// Contact Status activation deactivation change event
$(document).on('change', '.isActive', function () {
    let contactId = $(this).attr('data-id');
    activeDeActiveContact(contactId);
});

// activate de-activate Contact Status
window.activeDeActiveContact = function (id) {
    $.ajax({
        url: contactUrl + id + '/active-deactive',
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
        complete: function () {
            stopLoader();
        },
    });
};

$(document).on('mouseenter', '.livewire-card', function () {
    $(this).find('.action-dropdown').removeClass('d-none');
});

$(document).on('mouseleave', '.livewire-card', function () {
    $(this).find('.action-dropdown').addClass('d-none');
    $(this).parent().trigger('click');
});

$(document).on('change', '#isEnableId', function () {
    let contactStatus = $(this).val();
    window.livewire.emit('contactStatus', contactStatus);
});

document.addEventListener('livewire:load', function (event) {
    window.livewire.hook('message.processed', (message, component) => {
        $('#isEnableId').select2({
            width: '150px',
        });
    });
});
