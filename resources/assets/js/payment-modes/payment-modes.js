'use strict';

$(document).ready(function () {

    $('#filterActivePaymentMode').select2({
        width: '150px',
    });

});

$(document).on('change', '#filterActivePaymentMode', function () {
    window.livewire.emit('filterStatus', $(this).val());
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');

    let description = $('<div />').
        html($('#createDescription').summernote('code'));
    let empty = description.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#createDescription').summernote('isEmpty')) {
        $('#createDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#addNewForm', '#btnSave', 'reset');
        return false;
    }

    $.ajax({
        url: paymentModeCreateUrl,
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
    let paymentModeId = $(event.currentTarget).data('id');
    renderData(paymentModeId);
});

window.renderData = function (id) {
    $.ajax({
        url: paymentModeUrl + '/' + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#paymentModeId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.name;
                $('#editName').val(element.value);
                $('#editDescription').
                    summernote('code', result.data.description);
                if (result.data.active) {
                    $('#editActive').prop('checked', true);
                }
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
    let id = $('#paymentModeId').val();

    let editDescription = $('<div />').
        html($('#editDescription').summernote('code'));
    let empty = editDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#editDescription').summernote('isEmpty')) {
        $('#editDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#editForm', '#btnEditSave', 'reset');
        return false;
    }

    $.ajax({
        url: paymentModeUrl + '/' + id,
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
    let paymentModeId = $(this).attr('data-id');
    deleteItemLiveWire(paymentModeUrl + '/' + paymentModeId, 'Payment Mode');
});

$('#addModal').on('show.bs.modal', function () {
    $('.note-toolbar-wrapper').removeAttr('style');
    $('.note-toolbar').removeAttr('style');
});

$('#editModal').on('show.bs.modal', function () {
    $('.note-toolbar-wrapper').removeAttr('style');
    $('.note-toolbar').removeAttr('style');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#createDescription').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

$(document).on('change', '#invoicesOnly, #expensesOnly', function () {
    checkforDisable('#invoicesOnly', '#expensesOnly');
});

$(document).on('change', '#editInvoicesOnly, #editExpensesOnly', function () {
    checkforDisable('#editInvoicesOnly', '#editExpensesOnly');
});

const checkforDisable = (invoices, expenses) => {
    if ($(invoices).prop('checked') == true) {
        $(expenses).attr('disabled', true);
    } else if ($(expenses).prop('checked') == true) {
        $(invoices).attr('disabled', true);
    } else {
        $(invoices).attr('disabled', false);
        $(expenses).attr('disabled', false);
    }
};

// payment mode activation deactivation change event
$(document).on('change', '.isActive', function () {
    let paymentModeId = $(this).attr('data-id');
    activeDeActivePaymentMode(paymentModeId);
});

// activate de-activate PaymentMode
window.activeDeActivePaymentMode = function (id) {
    $.ajax({
        url: paymentModeUrl + '/' + id + '/active-deactive',
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

// Show Payment Mode details on modal
$(document).on('click', '.show-btn', function (e) {
    let paymentModeId = $(e.currentTarget).attr('data-id');
    $.ajax({
        url: paymentModeUrl + '/' + paymentModeId,
        type: 'GET',
        beforeSend: function () {
            startLoader();
        },
        complete: function () {
            stopLoader();
        },
        success: function (result) {
            if (result.success) {
                $('#showName').html('');
                $('#showDescription').html('');
                $('#showName').append(result.data.name);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.description;
                let description = element.value;
                $('#showDescription').append(description ? description : 'N/A');
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});
