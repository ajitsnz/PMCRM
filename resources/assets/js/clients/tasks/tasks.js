'use strict';

let tableName = '#clientTasksTbl';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[2, 'desc']],
    ajax: {
        url: taskUrl,
        data: function (data) {
            data.owner_id = ownerId;
            data.owner_type = ownerType;
        },
    },
    columnDefs: [
        {
            'targets': [1],
            'width': '10%',
        },
        {
            'targets': [2, 3, 5],
            'width': '20%',
        },
        {
            'targets': [4],
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
                let element = document.createElement('textarea');
                element.innerHTML = row.subject;
                let showLink = taskUrl + '/' + row.id;
                return '<a class="font-weight-bold anchor-underline" href="' +
                    showLink + '">' +
                    element.value + '</a>';
            },
            name: 'subject',
        },
        {
            data: function (row) {
                let priorities = row.priority;
                const taskPriorities = {
                    '1': 'Low',
                    '2': 'Medium',
                    '3': 'High',
                    '4': 'Urgent',
                };
                return taskPriorities[priorities];
            },
            name: 'priority',
        },
        {
            data: function (row) {
                if (row.start_date) {
                    return moment(row.start_date, 'YYYY-MM-DD hh:mm:ss').
                        format('Do MMM, Y HH:mm A');
                }
            },
            name: 'start_date',
        },
        {
            data: function (row) {
                if (row.due_date != null) {
                    return moment(row.due_date, 'YYYY-MM-DD hh:mm:ss').
                        format('Do MMM, Y HH:mm A');
                }
            },
            name: 'due_date',
        },
        {
            data: function (row) {
                if (row.member_id !== null) {
                    return '<img src="' + row.user.image_url +
                        '" class="thumbnail-rounded" data-toggle="tooltip" title="' +
                        row.user.full_name + '">';
                }
                return 'N/A';
            },
            name: 'member_id',
        },
        {
            data: function (row) {
                let status = row.status;
                const statusArray = {
                    '1': 'Not Started',
                    '2': 'In Progress',
                    '3': 'Testing',
                    '4': 'Awaiting Feedback',
                    '5': 'Completed',
                };
                const statusColor = {
                    '1': 'danger',
                    '2': 'primary',
                    '3': 'warning',
                    '4': 'info',
                    '5': 'success',

                };
                return '<span class="badge badge-' + statusColor[status] +
                    '">' + statusArray[status] + '</span>';
            },
            name: 'status',
        },
    ],
});

$(tableName).on('draw.dt', function () {
    $('.tooltip').tooltip('hide');
    setTimeout(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
