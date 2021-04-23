'use strict';

$(document).ready(function () {

    $('#filterTemplate,#filterDisabledTemplate').
        select2({
            width: '200px',
        });
});

let tableName = '#emailTemplatesTable';
$(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: emailTemplateUrl,
        data: function (data) {
            data.template_type = $('#filterTemplate').
                find('option:selected').
                val();

            data.disabled = $('#filterDisabledTemplate').
                find('option:selected').
                val();
        },
    },
    columnDefs: [
        {
            'targets': [1],
            'orderable': false,
            'className': 'text-center',
            'width': '5%',
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: function (row) {
                let editLink = emailTemplateUrl + row.id + '/edit';
                return '<a href="' + editLink + '">' +
                    row.template_name + '</a>';
            },
            name: 'template_name',
        },
        {
            data: function (row) {
                let checked = row.disabled === 0 ? '' : 'checked';
                let data = [{ 'id': row.id, 'checked': checked }];
                return prepareTemplateRender('#enableTemplate',
                    data);
            }, name: 'subject',
        },
    ],
    'fnInitComplete': function () {
        $(document).
            on('change', '#filterDisabledTemplate,#filterTemplate',
                function () {
                    $(tableName).DataTable().ajax.reload(null, true);
                });
    },
});

// Template enable disable change event
$(document).on('change', '.isEnable', function (event) {
    let templateId = $(event.currentTarget).data('id');
    activeDeActiveTemplate(templateId);
});

// enable disable Template
window.activeDeActiveTemplate = function (id) {
    $.ajax({
        url: emailTemplateUrl + id + '/enable-disable',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                $(tableName).DataTable().ajax.reload(null, false);
            }
        },
    });
};
