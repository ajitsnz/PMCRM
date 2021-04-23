'use strict';

let tableName = '#leadStatusTbl';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[2, 'asc']],
    ajax: {
        url: leadStatusUrl,
    },
    columnDefs: [
        {
            'targets': [1],
            'width': '8%',
            'orderable': false,
        },
        {
            'targets': [2],
            'className': 'text-right',
            'width': '8%',
        },
        {
            'targets': [3],
            'className': 'text-center',
            'width': '8%',
            'searchable': false,
        },
        {
            'targets': [4],
            'orderable': false,
            'className': 'text-center',
            'width': '7%',
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
                let data = [{ 'color': row.color, 'colorStyle': 'style' }];
                if (row.color == null)
                    return 'N/A';
                else
                    return prepareTemplateRender('#leadStatusColorBox', data);
            },
            name: 'color',
        },
        {
            data: 'order',
            name: 'order',
        },
        {
            data: 'leads_count',
            name: 'leads_count',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#leadStatusActionTemplate', data);
            }, name: 'id',
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

$(document).on('click', '.addLeadStatusModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {

    if ($('#color').val() == '') {
        displayErrorMessage('Please select your color.');
        return false;
    }

    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: leadStatusSaveUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $('#leadStatusTbl').DataTable().ajax.reload(null, false);
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
    let leadStatusId = $(event.currentTarget).data('id');
    renderData(leadStatusId);
});

window.renderData = function (id) {
    $.ajax({
        url: leadStatusUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#leadStatusId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.name;
                $('#editName').val(element.value);
                editPickr.setColor(result.data.color);
                $('#editOrder').val(result.data.order);
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
    let id = $('#leadStatusId').val();
    $.ajax({
        url: leadStatusUrl + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $('#leadStatusTbl').DataTable().ajax.reload(null, false);
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
    let leadStatusId = $(event.currentTarget).data('id');
    deleteItem(leadStatusUrl + leadStatusId, '#leadStatusTbl', 'Lead Status');
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
