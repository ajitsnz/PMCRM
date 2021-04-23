'use strict';

$(document).ready(function () {

    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    };

    let count = 1;
    $(window).scroll(function () {
        if ($(window).scrollTop() === $(document).height() -
            $(window).height()) {
            loadArticle(count);
            count++;
        }
    });

    let dataCount = false;

    function loadArticle (count) {
        if (!dataCount) {
            $('.load-more-logs').show();
            $.ajax({
                url: activityLogsUrl + '?page=' + count,
                type: 'get',
                success: function (result) {
                    if (result.success) {
                        let activityLogs = '';
                        let index;
                        if (result.data.data.length > 0) {
                            dataCount = false;
                            for (index = 1; index <
                            result.data.data.length; ++index) {
                                let data = [
                                    {
                                        'created_at': humanReadableFormatDate(
                                            result.data.data[index].created_at),
                                        'subject_type': activityLogIconJS(
                                            result.data.data[index].subject_type),
                                        'created_by': result.data.data[index].created_by.full_name,
                                        'description': result.data.data[index].description,
                                    }];
                                let activityLogDiv = prepareTemplateRender(
                                    '#activityLogsTemplate', data);
                                activityLogs += activityLogDiv;
                            }
                        } else {
                            dataCount = true;
                            $('.load-more-logs').hide();
                            $('.no-found-more-logs').
                                html('No more records found');
                        }

                        $('.activities').append(activityLogs);
                    }
                },
                error: function (result) {
                    manageAjaxErrors(result);
                },
            });
        }
    }

    function humanReadableFormatDate (date) {
        return moment(date).fromNow();
    }

    function activityLogIconJS (model) {
        let className = model.substring(11);
        if (className === 'CustomerGroup') {
            return 'fas fa-people-arrows';
        } else if (className === 'Customer') {
            return 'fas fa-street-view';
        } else if (className === 'User') {
            return 'fas fa-user';
        } else if (className === 'ArticleGroup') {
            return 'fas fa-edit';
        } else if (className === 'Article') {
            return 'fab fa-autoprefixer';
        } else if (className === 'Tag') {
            return 'fas fa-tty';
        } else if (className === 'LeadStatus') {
            return 'fas fa-blender-phone';
        } else if (className === 'LeadSource') {
            return 'fas fa-globe';
        } else if (className === 'Lead') {
            return 'fas fa-file-invoice';
        } else if (className === 'Project') {
            return 'fas fa-layer-group';
        } else if (className === 'Task') {
            return 'fas fa-tasks';
        } else if (className === 'TicketPriority') {
            return 'fas fa-sticky-note';
        } else if (className === 'TicketStatus') {
            return 'fas fa-info-circle';
        } else if (className === 'PredefinedReply') {
            return 'fas fa-reply';
        } else if (className === 'Ticket') {
            return 'fas fa-ticket-alt';
        } else if (className === 'Invoice') {
            return 'fas fa-file-invoice';
        } else if (className === 'CreditNote') {
            return 'fas fa-clipboard';
        } else if (className === 'Proposal') {
            return 'fas fa-scroll';
        } else if (className === 'Estimate') {
            return 'fas fa-calculator';
        } else if (className === 'Payment') {
            return 'fas fa-money-check-alt';
        } else if (className === 'Department') {
            return 'fas fa-columns';
        } else if (className === 'ExpenseCategory') {
            return 'fas fa-list-ol';
        } else if (className === 'Expense') {
            return 'fab fa-erlang';
        } else if (className === 'PaymentMode') {
            return 'fab fa-product-hunt';
        } else if (className === 'TaxRate') {
            return 'fas fa-percent';
        } else if (className === 'Announcement') {
            return 'fas fa-bullhorn';
        } else if (className === 'Item') {
            return 'fas fa-sitemap';
        } else if (className === 'ItemGroup') {
            return 'fas fa-object-group';
        } else if (className === 'ContractType') {
            return 'fas fa-file-contract';
        } else if (className === 'Contract') {
            return 'fas fa-file-signature';
        } else if (className === 'Goal') {
            return 'fas fa-bullseye';
        } else if (className === 'Service') {
            return 'fab fa-stripe-s';
        } else if (className === 'Reminder') {
            return 'fas fa-bell';
        } else if (className === 'Note') {
            return 'fas fa-sticky-note';
        } else if (className === 'Comment') {
            return 'fas fa-comment';
        } else if (className === 'Contact') {
            return 'fas fa-user';
        }

    }
});
