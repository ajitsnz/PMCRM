'use strict';

let tableName = '#paymentsTbl';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[2, 'desc']],
    ajax: {
        url: paymentUrl,
        data: function (data) {
            data.owner_type = ownerType;
            data.owner_id = invoiceId;
        },
    },
    columnDefs: [
        {
            'targets': [4],
            'orderable': false,
            'className': 'text-center',
            'width': '10%',
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: 'payment_mode.name',
            name: 'payment_mode',
        },
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.note;
                if (element.value != '')
                    return element.value;
                else
                    return 'N/A';
            },
            name: 'note',
        },
        {
            data: function (row) {
                return row;
            },
            render: function (row) {
                return moment(row.payment_date).format('Do MMM, Y h:mm A');
            },
            name: 'payment_date',
        },
        {
            data: function (row) {
                return '<i class="' + currentCurrencyClass + '"></i>' + ' ' +
                    currency(row.amount_received, { precision: 0 }).format() +
                    '</i>';
            },
            name: 'amount_received',
        },
        {
            data: function (row) {
                let data = [
                    {
                        'id': row.id,
                    }];
                return prepareTemplateRender('#paymentActionTemplate', data);
            }, name: 'id',
        },
    ],
});

