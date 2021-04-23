'use strict';

let tableName = '#paymentsTbl';
$(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[2, 'desc']],
    ajax: {
        url: paymentUrl,
        data: function (data) {
            data.owner_type = ownerType;
        },
    },
    columnDefs: [
        {
            'targets': [3],
            'className': 'text-right',
            'width': '10%',
        },
        {
            'targets': [0, 2],
            'width': '15%',
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: 'payment_mode.name',
            name: 'paymentMode.name',
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
                    getFormattedPrice(row.amount_received) +
                    '</i>';
            },
            name: 'amount_received',
        },
    ],
});
