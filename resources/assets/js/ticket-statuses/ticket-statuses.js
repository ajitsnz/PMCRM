'use strict';

let tableName = '#ticketStatusTbl';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: ticketStatusUrl,
    },
    columnDefs: [
        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '6%',
        },
        {
            'targets': [1],
            'width': '8%',
            'orderable': false,
        },
        {
            'targets': [2],
            'className': 'text-center',
            'width': '8%',
            'searchable': false,
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.name;
                return element.value;
            },
            name: 'name',
        },
        {
            data: function (row) {
                let data = [{ 'color': row.pick_color  ,'ticketStyle' : 'style' }];
                return prepareTemplateRender('#ticketStatusColorBox', data);
            },
            name: 'pick_color',
        },
        {
            data: 'tickets_count',
            name: 'tickets_count',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#ticketStatusActionTemplate',
                    data);
            },
            name: 'id',
        },
    ],
});

const pickr = Pickr.create({
    el: '.color-wrapper',
    theme: 'nano', // or 'monolith', or 'nano'
    closeWithKey: 'Enter',
    autoReposition: true,
    defaultRepresentation: 'HEX',
    position: 'bottom-end',
    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 1)',
        'rgba(156, 39, 176, 1)',
        'rgba(103, 58, 183, 1)',
        'rgba(63, 81, 181, 1)',
        'rgba(33, 150, 243, 1)',
        'rgba(3, 169, 244, 1)',
        'rgba(0, 188, 212, 1)',
        'rgba(0, 150, 136, 1)',
        'rgba(76, 175, 80, 1)',
        'rgba(139, 195, 74, 1)',
        'rgba(205, 220, 57, 1)',
        'rgba(255, 235, 59, 1)',
        'rgba(255, 193, 7, 1)',
    ],

    components: {
        // Main components
        preview: true,
        hue: true,

        // Input / output Options
        interaction: {
            input: true,
            clear: false,
            save: false,
        },
    },
});

const editPickr = Pickr.create({
    el: '.color-wrapper',
    theme: 'nano', // or 'monolith', or 'nano'
    closeWithKey: 'Enter',
    autoReposition: true,
    defaultRepresentation: 'HEX',
    position: 'bottom-end',
    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 1)',
        'rgba(156, 39, 176, 1)',
        'rgba(103, 58, 183, 1)',
        'rgba(63, 81, 181, 1)',
        'rgba(33, 150, 243, 1)',
        'rgba(3, 169, 244, 1)',
        'rgba(0, 188, 212, 1)',
        'rgba(0, 150, 136, 1)',
        'rgba(76, 175, 80, 1)',
        'rgba(139, 195, 74, 1)',
        'rgba(205, 220, 57, 1)',
        'rgba(255, 235, 59, 1)',
        'rgba(255, 193, 7, 1)',
    ],

    components: {
        // Main components
        preview: true,
        hue: true,

        // Input / output Options
        interaction: {
            input: true,
            clear: false,
            save: false,
        },
    },
});

pickr.on('change', function () {
    const color = pickr.getColor().toHEXA().toString();
    pickr.setColor(color);
    $('#color').val(color);
});

editPickr.on('change', function () {
    const editColor = editPickr.getColor().toHEXA().toString();
    editPickr.setColor(editColor);
    $('#edit_color').val(editColor);
});

let picked = false;

$(document).on('click', '#color', function () {
    picked = true;
});

$(document).on('click', '.addTicketStatusModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();

    if ($('#color').val() == '') {
        displayErrorMessage('Please select your color.');
        return false;
    }

    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: ticketStatusSaveUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $('#ticketStatusTbl').DataTable().ajax.reload(null, false);
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
    let ticketStatusId = $(event.currentTarget).data('id');
    renderData(ticketStatusId);
});

window.renderData = function (id) {
    $.ajax({
        url: ticketStatusUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#ticketStatusId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.name;
                $('#editName').val(element.value);
                editPickr.setColor(result.data.pick_color);
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
    let id = $('#ticketStatusId').val();
    $.ajax({
        url: ticketStatusUrl + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $('#ticketStatusTbl').DataTable().ajax.reload(null, false);
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

$(document).on('click', '.delete-btn', function (event) {
    let ticketStatusId = $(event.currentTarget).data('id');
    deleteItem(ticketStatusUrl + ticketStatusId, '#ticketStatusTbl',
        'Ticket Status');
});

$('#addModal').on('show.bs.modal', function () {
    pickr.setColor('#3F51B5');
});

$('#addModal').on('hidden.bs.modal', function () {
    pickr.setColor('#000');
    resetModalForm('#addNewForm', '#validationErrorsBox');
    pickr.hide();
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
    editPickr.hide();
});
