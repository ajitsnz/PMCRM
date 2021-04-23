'use strict';

$(document).ready(function () {

    $('#filter_status').
        select2({
            width: '150px',
        });

    $('#priorityId').select2({
        width: '150px',
    });

});

let tableName = '#tasksTbl';
$(tableName).DataTable({
    oLanguage: {
        'sEmptyTable': showNoDataMsg,
    },
    processing: true,
    serverSide: true,
    'order': [[2, 'desc']],
    ajax: {
        url: taskUrl,
        beforeSend: function () {
            startLoader();
        },
        data: function (data) {
            data.owner_id = ownerId;
            data.owner_type = ownerType;
            data.status = $('#filter_status').
                find('option:selected').
                val();
            data.priority = $('#priorityId').find('option:selected').val();
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
            'width': '6%',
        },
        {
            'targets': [1, 5],
            'width': '10%',
        },
        {
            'targets': [2, 3],
            'width': '15%',
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
                return priorities[row.priority];
            },
            name: 'priority',
        },
        {
            data: function (row) {
                if (row.start_date != null) {
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
        {
            data: function (row) {
                let url = taskUrl + '/' + row.id;
                let data = [
                    {
                        'id': row.id,
                        'editUrl': url + '/edit',
                    }];
                return prepareTemplateRender('#taskActionTemplate', data);
            }, name: 'id',
        },
    ],
    'fnInitComplete': function () {
        $(document).on('change', '#filter_status', function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
        $(document).on('change', '#priorityId', function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(document).on('click', '.delete-btn-task', function (event) {
    let taskId = $(event.currentTarget).data('id');
    deleteItem(taskUrl + '/' + taskId, '#tasksTbl', 'Task');
});

$(tableName).on('draw.dt', function () {
    $('.tooltip').tooltip('hide');
    setTimeout(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
