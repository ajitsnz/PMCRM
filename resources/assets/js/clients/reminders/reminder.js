'use strict';

let tableName = '#clientReminderTbl';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[0, 'desc']],
    ajax: {
        url: reminderUrl,
        data: function (data) {
            data.owner_id = $('#ownerId').val();
        },
    },
    columnDefs: [
        {
            'targets': [1],
            'orderable': false,
            'className': 'text-center',
            'width': '13%',
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: function (row) {
                return row;
            },
            render: function (row) {
                if (row.notified_date === null) {
                    return 'N/A';
                }

                return moment(row.notified_date).format('Do MMM, Y h:mm A');
            },
            name: 'notified_date',
        },
        {
            data: function (row) {
                return '<img src="' + row.user.image_url +
                    '" class="thumbnail-rounded" data-toggle="tooltip" title="' +
                    row.user.full_name + '">';
            },
            name: 'reminder_to',
        },
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.description;
                return element.value;
            },
            name: 'description',
        },
    ],
});

$(tableName).on('draw.dt', function () {
    $('.tooltip').tooltip('hide');
    setTimeout(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});

