'use strict';

let tbl = $('#customerGroupTable').DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: customerGroupUrl,
    },
    columnDefs: [
        {
            'targets': [1],
            render: function (data) {
                return data.length > 80 ?
                    data.substr(0, 80) + '...' :
                    data;
            },
        },
        {
            'targets': [2],
            'className': 'text-center',
            'width': '8%',
            'searchable': false,
            'orderable': true,
        },
        {
            'targets': [3],
            'className': 'text-center',
            'width': '6%',
            'orderable': false,
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
                if (row.description != '') {
                    let element = document.createElement('textarea');
                    element.innerHTML = row.description;
                    return element.value;
                } else
                    return 'N/A';
            },
            name: 'description',
        },
        {
            data: 'customers_count',
            name: 'customers_count',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#customerGroupActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});
