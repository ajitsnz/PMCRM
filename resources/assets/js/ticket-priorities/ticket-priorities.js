'use strict';

$(document).ready(function () {
    $('#filter_status').select2({
        width: '150px',
    });
});

$(document).on('change', '#filter_status', function () {
    window.livewire.emit('filterStatus', $(this).val());
});

$(document).on('click', '.addTicketPriorityModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: ticketPrioritySaveUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                window.livewire.emit('refresh');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#addNewForm', '#btnSave');
        },
    });
});

$(document).on('click', '.edit-btn', function (event) {
    let ticketPriorityId = $(event.currentTarget).data('id');
    renderData(ticketPriorityId);
});

window.renderData = function (id) {
    $.ajax({
        url: ticketPriorityUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#ticketPriorityId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.name;
                $('#editName').val(element.value);
                if (result.data.status)
                    $('#editStatus').prop('checked', true);
                $('#editModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};

$(document).on('submit', '#editForm', function (event) {
    event.preventDefault();
    processingBtn('#editForm', '#btnEditSave', 'loading');
    let id = $('#ticketPriorityId').val();
    $.ajax({
        url: ticketPriorityUrl + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                window.livewire.emit('refresh');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#editForm', '#btnEditSave');
        },
    });
});

$(document).on('click', '.delete-btn', function () {
    let ticketPriorityId = $(this).attr('data-id');
    deleteItemLiveWire(ticketPriorityUrl + ticketPriorityId, 'Ticket Priority');
});

// category activation deactivation change event
$(document).on('change', '.status', function (event) {
    let ticketPriorityId = $(event.currentTarget).data('id');
    activeDeActiveCategory(ticketPriorityId);
});

// activate de-activate category
window.activeDeActiveCategory = function (id) {
    $.ajax({
        url: ticketPriorityUrl + id + '/active-deactive',
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

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});
