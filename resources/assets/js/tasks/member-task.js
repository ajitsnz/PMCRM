'use strict';

$(document).ready(function () {
    $('#filter_status').
        select2({
            width: '150px',
        });
});

let tableName = '#member-tasksTbl';
$(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[2, 'desc']],
    ajax: {
        url: taskUrl,
        beforeSend: function () {
            startLoader();
        },
        data: function (data) {
            data.owner_id = null;
            data.member_id = member_id;
            data.status = $('#filter_status').
                find('option:selected').
                val();
        },
        complete: function () {
            stopLoader();
        },
    },
    columnDefs: [
        {
            'targets': [1, 2, 3, 5],
            'width': '14%',
        },
        {
            'targets': [4],
            'width': '8%',
        },
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
    ],
    columns: [
        {
            data: function (row) {
                let showLink = taskUrl + row.id;
                return '<a class="font-weight-bold anchor-underline" href="' +
                    showLink + '">' +
                    row.subject + '</a>';
            },
            name: 'subject',
        },
        {
            data: function (row) {
                return priorities[row.priority];
            },
            name: 'priority',
        },
        {
            data: function (row) {
                return moment(row.start_date, 'YYYY-MM-DD hh:mm:ss').
                    format('Do MMM, Y HH:mm A');
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
                const taskStatus = {
                    '1': 'Not Started',
                    '2': 'In Progress',
                    '3': 'Testing',
                    '4': 'Awaiting Feedback',
                    '5': 'Completed',
                };
                const badgeColor = {
                    '1': 'danger',
                    '2': 'primary',
                    '3': 'warning',
                    '4': 'info',
                    '5': 'success',
                };
                return '<span class="badge badge-' + badgeColor[status] + '">' +
                    taskStatus[status] + '</span>';
            },
            name: 'status',
        },
    ],
    'fnInitComplete': function () {
        $(document).on('change', '#filter_status', function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(tableName).on('draw.dt', function () {
    $('.tooltip').tooltip('hide');
    setTimeout(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});

