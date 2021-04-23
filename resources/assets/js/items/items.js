'use strict';

$(document).ready(function () {

    $('#filter_group').
        select2({
            width: '180px',
        });

    $('#taxSelectOne, #editTaxSelectOne').
        select2({
            width: '100%',
        });

    $('#taxSelectTwo,#editTaxSelectTwo').
        select2({
            width: '100%',
        });

    $('#itemGroup, #editItemGroup').select2({
        width: '100%',
        placeholder: 'Select Product Group',
    });

    $('#itemDescription, #editItemDescription').summernote({
        minHeight: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]],
    });
});

let tableName = '#itemsTable';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: itemUrl,
        beforeSend: function () {
            startLoader();
        },
        data: function (data) {
            data.group = $('#filter_group').
                find('option:selected').
                val();
        },
        complete: function () {
            stopLoader();
        },
    },
    columnDefs: [
        {
            'targets': [6],
            'orderable': false,
            'className': 'text-center',
            'width': '50px',
        },
        {
            'targets': [2],
            render: function (data) {
                return data.length > 80 ?
                    data.substr(0, 80) + '...' :
                    data;
            },
        },
        {
            'targets': [3, 4, 5],
            'className': 'text-right',
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
                element.innerHTML = row.title;
                return element.value;
            },
            name: 'title',
        },
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.group.name;
                return element.value;
            },
            name: 'item_group_id',
        },
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.description;
                if (element.value != '')
                    return element.value;
                else
                    return 'N/A';
            },
            name: 'description',
        },
        {
            data: function (row) {
                if (row.rate != 0) {
                    return '<i class="' + currentCurrencyClass + '"></i>' +
                        ' ' +
                        getFormattedPrice(row.rate);
                }
                return '<i class="' + currentCurrencyClass + '"></i>' + ' ' + 0;
            },
            name: 'rate',
        },
        {
            data: 'first_tax.tax_rate',
            name: 'firstTax.tax_rate',
        },
        {
            data: 'second_tax.tax_rate',
            name: 'firstTax.tax_rate',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#itemActionTemplate', data);
            }, name: 'id',
        },
    ],
    'fnInitComplete': function () {
        $(document).on('change', '#filter_group', function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');

    let itemDescription = $('<div />').
        html($('#itemDescription').summernote('code'));
    let empty = itemDescription.text().trim().replace(/ \r\n\t/g, '') === '';

    if ($('#itemDescription').summernote('isEmpty')) {
        $('#itemDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#addNewForm', '#btnSave', 'reset');
        return false;
    }

    $.ajax({
        url: itemCreateUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $('#itemsTable').DataTable().ajax.reload(null, false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#addNewForm','#btnSave');
        },
    });
});

$(document).on('click', '.edit-btn', function (event) {
    let itemId = $(event.currentTarget).data('id');
    renderData(itemId);
});

window.renderData = function (id) {
    $.ajax({
        url: itemUrl + '/' + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#itemId').val(result.data.id);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.title;
                $('#editTitle').val(element.value);
                $('#editItemDescription').
                    summernote('code', result.data.description);
                $('#editRate').val(result.data.rate);
                $('.price-input').trigger('input');
                $('#editTaxSelectOne').
                    val(result.data.tax_1_id).
                    trigger('change');
                $('#editTaxSelectTwo').
                    val(result.data.tax_2_id).
                    trigger('change');
                $('#editItemGroup').
                    val(result.data.item_group_id).
                    trigger('change');
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
    let id = $('#itemId').val();

    let editItemDescription = $('<div />').
        html($('#editItemDescription').summernote('code'));
    let empty = editItemDescription.text().trim().replace(/ \r\n\t/g, '') ===
        '';

    if ($('#editItemDescription').summernote('isEmpty')) {
        $('#editItemDescription').val('');
    } else if (empty) {
        displayErrorMessage(
            'Description field is not contain only white space');
        processingBtn('#editForm', '#btnEditSave', 'reset');
        return false;
    }

    $.ajax({
        url: itemUrl + '/' + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $('#itemsTable').DataTable().ajax.reload(null, false);
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
    let itemId = $(event.currentTarget).data('id');
    deleteItem(itemUrl + '/' + itemId, '#itemsTable', 'Product');
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
    $('#itemDescription').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

