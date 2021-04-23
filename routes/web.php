<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect::to('/login');
})->name('redirect.login');


Auth::routes(['verify' => true]);

/** account verification route */
Route::get('activate', 'Auth\RegisterController@verifyAccount')->name('activate');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('articles', 'Web\ArticleController@index')->name('articles.index');
Route::get('search-article', 'Web\ArticleController@searchArticle')->name('article.search');
Route::get('articles/{article}', 'Web\ArticleController@show')->name('articles.show');

Route::group(['middleware' => ['auth', 'xss', 'checkUserStatus'], 'prefix' => 'admin'],
    function () {

        // Dashboard route
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        // Customer groups routes
        Route::group(['middleware' => 'permission:manage_customer_groups'], function () {
            Route::get('customer-groups', 'CustomerGroupController@index')->name('customer-groups.index');
            Route::post('customer-groups', 'CustomerGroupController@store')->name('customer-groups.store');
            Route::get('customer-groups/create', 'CustomerGroupController@create')->name('customer-groups.create');
            Route::put('customer-groups/{customerGroup}',
                'CustomerGroupController@update')->name('customer-groups.update');
            Route::get('customer-groups/{customerGroup}', 'CustomerGroupController@show')->name('customer-groups.show');
            Route::delete('customer-groups/{customerGroup}',
                'CustomerGroupController@destroy')->name('customer-groups.destroy');
            Route::get('customer-groups/{customerGroup}/edit',
                'CustomerGroupController@edit')->name('customer-groups.edit');
        });
        
        // Tags module routes
        Route::group(['middleware' => 'permission:manage_tags'], function () {
            Route::get('tags', 'TagController@index')->name('tags.index');
            Route::post('tags', 'TagController@store')->name('tags.store');
            Route::get('tags/{tag}/edit', 'TagController@edit')->name('tags.edit');
            Route::put('tags/{tag}', 'TagController@update')->name('tags.update');
            Route::delete('tags/{tag}', 'TagController@destroy')->name('tags.destroy');
            Route::get('tags/{tag}', 'TagController@show')->name('tags.show');
        });

        // Customers routes
        Route::group(['middleware' => 'permission:manage_customers'], function () {
            Route::get('customers', 'CustomerController@index')->name('customers.index');
            Route::get('customers/create', 'CustomerController@create')->name('customers.create');
            Route::post('customers', 'CustomerController@store')->name('customers.store');
            Route::get('customers/{customer}', 'CustomerController@show')->name('customers.show');
            Route::get('customers/{customer}/edit', 'CustomerController@edit')->name('customers.edit');
            Route::put('customers/{customer}', 'CustomerController@update')->name('customers.update');
            Route::delete('customers/{customer}', 'CustomerController@destroy')->name('customers.destroy');
            Route::get('customers/{customer}/{group}', 'CustomerController@show')->name('customers.show');
            Route::get('customers/{customer}/{group}/notes-count',
                'CustomerController@getNotesCount')->name('customer.notes-count');
            Route::get('search-customers', 'CustomerController@searchCustomer')->name('customers.search.customer');
        });
        Route::post('add-customer-address','CustomerController@addCustomerAddress')->name('add.customer.address');
        // Contacts routes
        Route::get('contacts', 'ContactController@index')->name('contacts.index');
        Route::get('contacts/create/{customerId?}', 'ContactController@create')->name('contacts.create');
        Route::post('contacts', 'ContactController@store')->name('contacts.store');
        Route::get('contacts/{contact}', 'ContactController@show')->name('contacts.show');
        Route::get('contacts/{contact}/edit', 'ContactController@edit')->name('contacts.edit');
        Route::post('contacts/{contact}', 'ContactController@update')->name('contacts.update');
        Route::delete('contacts/{contact}', 'ContactController@destroy')->name('contacts.destroy');
        Route::post('contacts/{contact}/active-deactive', 'ContactController@activeDeActiveContact');

        // Notes routes
        Route::get('notes', 'NoteController@index')->name('notes.index');
        Route::post('notes', 'NoteController@store')->name('notes.store');
        Route::get('notes/{note}/edit', 'NoteController@edit')->name('notes.edit');
        Route::put('notes/{note}', 'NoteController@update')->name('notes.update');
        Route::delete('notes/{note}', 'NoteController@destroy')->name('notes.destroy');

        // Reminders routes
        Route::get('reminder', 'ReminderController@index')->name('reminder.index');
        Route::post('reminder', 'ReminderController@store')->name('reminder.store');
        Route::get('reminder/{reminder}/edit', 'ReminderController@edit')->name('reminder.edit');
        Route::put('reminder/{reminder}', 'ReminderController@update')->name('reminder.update');
        Route::delete('reminder/{reminder}', 'ReminderController@destroy')->name('reminder.destroy');
        Route::post('reminder/{reminder}/active-deactive-notified', 'ReminderController@activeDeActiveNotified');
        Route::post('reminder/{reminder}/change-status', 'ReminderController@statusChange');

        // Comments routes
        Route::get('comments', 'CommentController@index')->name('comments.index');
        Route::post('comments', 'CommentController@store')->name('comments.store');
        Route::put('comments/{comment}', 'CommentController@update')->name('comments.update');
        Route::delete('comments/{comment}', 'CommentController@destroy')->name('comments.destroy');
        Route::get('comments/{comment}/edit', 'CommentController@edit')->name('comments.edit');


        // Departments routes
        Route::group(['middleware' => 'permission:manage_departments'], function () {
            Route::get('departments', 'DepartmentController@index')->name('departments.index');
            Route::post('departments', 'DepartmentController@store')->name('departments.store');
            Route::get('departments/{department}/edit', 'DepartmentController@edit')->name('departments.edit');
            Route::put('departments/{department}', 'DepartmentController@update')->name('departments.update');
            Route::delete('departments/{department}', 'DepartmentController@destroy')->name('departments.destroy');
        });

        // Article Groups module routes
        Route::group(['middleware' => 'permission:manage_article_groups'], function () {
            Route::get('article-groups', 'ArticleGroupController@index')->name('article-groups.index');
            Route::post('article-groups', 'ArticleGroupController@store')->name('article-groups.store');
            Route::get('article-groups/{articleGroup}/edit',
                'ArticleGroupController@edit')->name('article-groups.edit');
            Route::put('article-groups/{articleGroup}', 'ArticleGroupController@update')->name('article-groups.update');
            Route::delete('article-groups/{articleGroup}',
                'ArticleGroupController@destroy')->name('article-groups.destroy');
        });

        // Expenses Categories routes
        Route::group(['middleware' => 'permission:manage_expense_category'], function () {
            Route::get('expense-categories', 'ExpenseCategoryController@index')->name('expense-categories.index');
            Route::post('expense-categories', 'ExpenseCategoryController@store')->name('expense-categories.store');
            Route::get('expense-categories/{expenseCategory}/edit',
                'ExpenseCategoryController@edit')->name('expense-categories.edit');
            Route::put('expense-categories/{expenseCategory}',
                'ExpenseCategoryController@update')->name('expense-categories.update');
            Route::delete('expense-categories/{expenseCategory}',
                'ExpenseCategoryController@destroy')->name('expense-categories.destroy');
        });

        // Predefined Replies routes
        Route::group(['middleware' => 'permission:manage_predefined_replies'], function () {
            Route::get('predefined-replies', 'PredefinedReplyController@index')->name('predefinedReplies.index');
            Route::post('predefined-replies', 'PredefinedReplyController@store')->name('predefinedReplies.store');
            Route::get('predefined-replies/{predefinedReply}/edit',
                'PredefinedReplyController@edit')->name('predefinedReplies.edit');
            Route::put('predefined-replies/{predefinedReply}',
                'PredefinedReplyController@update')->name('predefinedReplies.update');
            Route::delete('predefined-replies/{predefinedReply}',
                'PredefinedReplyController@destroy')->name('predefinedReplies.destroy');
            Route::get('predefined-replies/{predefinedReply}',
                'PredefinedReplyController@show')->name('predefinedReplies.show');
        });

        // Services routes
        Route::group(['middleware' => 'permission:manage_services'], function () {
            Route::get('services', 'ServiceController@index')->name('services.index');
            Route::post('services', 'ServiceController@store')->name('services.store');
            Route::get('services/{service}/edit', 'ServiceController@edit')->name('services.edit');
            Route::put('services/{service}', 'ServiceController@update')->name('services.update');
            Route::delete('services/{service}', 'ServiceController@destroy')->name('services.destroy');
        });

        // Items routes
        Route::group(['middleware' => 'permission:manage_items'], function () {
            Route::get('items', 'ItemController@index')->name('items.index');
            Route::post('items', 'ItemController@store')->name('items.store');
            Route::get('items/{item}/edit', 'ItemController@edit')->name('items.edit');
            Route::put('items/{item}', 'ItemController@update')->name('items.update');
            Route::delete('items/{item}', 'ItemController@destroy')->name('items.destroy');
        });

        // Tax Rates routes
        Route::group(['middleware' => 'permission:manage_tax_rates'], function () {
            Route::get('tax-rates', 'TaxRateController@index')->name('tax-rates.index');
            Route::post('tax-rates', 'TaxRateController@store')->name('tax-rates.store');
            Route::get('tax-rates/{taxRate}/edit', 'TaxRateController@edit')->name('tax-rates.edit');
            Route::put('tax-rates/{taxRate}', 'TaxRateController@update')->name('tax-rates.update');
            Route::delete('tax-rates/{taxRate}', 'TaxRateController@destroy')->name('tax-rates.destroy');
        });

        // Articles routes
        Route::group(['middleware' => 'permission:manage_articles'], function () {
            Route::get('articles', 'ArticleController@index')->name('articles.index');
            Route::get('articles/create', 'ArticleController@create')->name('articles.create');
            Route::post('articles', 'ArticleController@store')->name('articles.store');
            Route::get('articles/{article}', 'ArticleController@show')->name('articles.show');
            Route::get('articles/{article}/edit', 'ArticleController@edit')->name('articles.edit');
            Route::post('articles/{article}', 'ArticleController@update')->name('articles.update');
            Route::delete('articles/{article}', 'ArticleController@destroy')->name('articles.destroy');
            Route::post('articles/{article}/active-deactive-article',
                'ArticleController@activeDeActiveInternalArticle')->name('active.deactive.article');
            Route::post('articles/{article}/active-deactive-disabled',
                'ArticleController@activeDeActiveDisabled')->name('active.deactive.disabled');
            Route::get('attachment-download/{article}', 'ArticleController@downloadMedia');
        });

        // Item Groups routes
        Route::group(['middleware' => 'permission:manage_items_groups'], function () {
            Route::get('item-groups', 'ItemGroupController@index')->name('item-groups.index');
            Route::post('item-groups', 'ItemGroupController@store')->name('item-groups.store');
            Route::get('item-groups/{itemGroup}/edit', 'ItemGroupController@edit')->name('item-groups.edit');
            Route::put('item-groups/{itemGroup}', 'ItemGroupController@update')->name('item-groups.update');
            Route::delete('item-groups/{itemGroup}', 'ItemGroupController@destroy')->name('item-groups.destroy');
        });

        // Announcements routes
        Route::group(['middleware' => 'permission:manage_announcements'], function () {
            Route::get('announcements', 'AnnouncementController@index')->name('announcements.index');
            Route::post('announcements', 'AnnouncementController@store')->name('announcements.store');
            Route::get('announcements/{announcement}', 'AnnouncementController@show')->name('announcements.show');
            Route::get('announcements/{announcement}/edit', 'AnnouncementController@edit')->name('announcements.edit');
            Route::put('announcements/{announcement}', 'AnnouncementController@update')->name('announcements.update');
            Route::delete('announcements/{announcement}',
                'AnnouncementController@destroy')->name('announcements.destroy');
            Route::post('announcements/{announcement}/active-deactive-client',
                'AnnouncementController@activeDeActiveClient');
            Route::get('announcement-detail/{announcement}',
                'AnnouncementController@getAnnouncementDetails')->name('announcement.details');
            Route::post('announcements/{announcement}/change-status', 'AnnouncementController@statusChange');
        });

        // Calendar routes
        Route::group(['middleware' => 'permission:manage_calenders'], function () {
            Route::get('calendars', 'CalendarController@index')->name('calendars.index');
            Route::get('calendar-list', 'CalendarController@calendarList');
        });

        // Contracts type routes
        Route::group(['middleware' => 'permission:manage_contracts_types'], function () {
            Route::get('contract-types', 'ContractTypeController@index')->name('contract-types.index');
            Route::post('contract-types', 'ContractTypeController@store')->name('contract-types.store');
            Route::get('contract-types/{contractType}/edit',
                'ContractTypeController@edit')->name('contract-types.edit');
            Route::put('contract-types/{contractType}', 'ContractTypeController@update')->name('contract-types.update');
            Route::delete('contract-types/{contractType}',
                'ContractTypeController@destroy')->name('contract-types.destroy');
        });

        // Members routes
        Route::group(['middleware' => 'permission:manage_staff_member'], function () {
            Route::get('members', 'MemberController@index')->name('members.index');
            Route::post('members', 'MemberController@store')->name('members.store');
            Route::get('members/create', 'MemberController@create')->name('members.create');
            Route::get('members/{member}/edit', 'MemberController@edit')->name('members.edit');
            Route::put('members/{member}', 'MemberController@update')->name('members.update');
            Route::get('members/{member}', 'MemberController@show')->name('members.show');
            Route::get('members/{member}/{group}', 'MemberController@show')->name('members.show');
            Route::delete('members/{member}', 'MemberController@destroy')->name('members.destroy');
            Route::post('members/{member}/active-deactive-administrator',
                'MemberController@activeDeActiveAdministrator');
            Route::post('members/{member}/email-send', 'MemberController@resendEmailVerification')->name('email-send');
        });

        // Expenses routes
        Route::group(['middleware' => 'permission:manage_expenses'], function () {
            Route::get('expenses', 'ExpenseController@index')->name('expenses.index');
            Route::get('expenses/create', 'ExpenseController@create')->name('expenses.create');
            Route::post('expenses', 'ExpenseController@store')->name('expenses.store');
            Route::get('expenses/{expense}', 'ExpenseController@show')->name('expenses.show');
            Route::get('expenses/{expense}/edit', 'ExpenseController@edit')->name('expenses.edit');
            Route::put('expenses/{expense}', 'ExpenseController@update')->name('expenses.update');
            Route::delete('expenses/{expense}', 'ExpenseController@destroy')->name('expenses.destroy');
            Route::get('expense-attachment-download/{expense}', 'ExpenseController@downloadMedia');
            Route::get('expenses/{expense}/comments-count',
                'ExpenseController@getCommentsCount')->name('expense.comments.count');
            Route::get('expenses/{expense}/{group}', 'ExpenseController@show')->name('expenses.show');
            Route::get('expenses/{expense}/{group}/notes-count',
                'ExpenseController@getNotesCount')->name('expense.notes.count');
            Route::get('expense-download-media/{mediaItem}',
                'ExpenseController@download')->name('expense.download.media');
        });

        // Leads routes
        Route::group(['middleware' => 'permission:manage_leads'], function () {
            Route::get('leads', 'LeadController@index')->name('leads.index');
            Route::get('leads/create/{customerId?}', 'LeadController@create')->name('leads.create');
            Route::post('leads', 'LeadController@store')->name('leads.store');
            Route::get('leads/{lead}', 'LeadController@show')->name('leads.show');
            Route::get('leads/{lead}/edit', 'LeadController@edit')->name('leads.edit');
            Route::put('leads/{lead}', 'LeadController@update')->name('leads.update');
            Route::delete('leads/{lead}', 'LeadController@destroy')->name('leads.destroy');
            Route::put('leads/{lead}/status/{status}', 'LeadController@changeStatus')->name('leads.changeStatus');
            Route::get('leads-kanban-list', 'LeadController@kanbanList')->name('leads.kanbanList');
            Route::post('contact-as-per-customer',
                'LeadController@contactAsPerCustomer')->name('leads.contactAsPerCustomer');
            Route::get('leads/{lead}/{group}', 'LeadController@show')->name('leads.show');
            Route::get('leads/{lead}/{group}/notes-count',
                'LeadController@getNotesCount')->name('lead.notes-count');
            Route::post('lead-convert-customer',
                'CustomerController@leadConvertToCustomer')->name('lead.convert.customer');
        });

        // Goals routes
        Route::group(['middleware' => 'permission:manage_goals'], function () {
            Route::get('goals', 'GoalController@index')->name('goals.index');
            Route::post('goals', 'GoalController@store')->name('goals.store');
            Route::get('goals/create', 'GoalController@create')->name('goals.create');
            Route::put('goals/{goal}', 'GoalController@update')->name('goals.update');
            Route::get('goals/{goal}', 'GoalController@show')->name('goals.show');
            Route::delete('goals/{goal}', 'GoalController@destroy')->name('goals.destroy');
            Route::get('goals/{goal}/edit', 'GoalController@edit')->name('goals.edit');
        });

        // Contracts routes
        Route::group(['middleware' => 'permission:manage_contracts'], function () {
            Route::get('contracts', 'ContractController@index')->name('contracts.index');
            Route::post('contracts', 'ContractController@store')->name('contracts.store');
            Route::get('contracts/create', 'ContractController@create')->name('contracts.create');
            Route::put('contracts/{contract}', 'ContractController@update')->name('contracts.update');
            Route::get('contracts/{contract}', 'ContractController@show')->name('contracts.show');
            Route::delete('contracts/{contract}', 'ContractController@destroy')->name('contracts.destroy');
            Route::get('contracts/{contract}/edit', 'ContractController@edit')->name('contracts.edit');
            Route::get('contracts/{contract}/{group}', 'ContractController@show')->name('contracts.show');
        });

        // Proposals routes
        Route::group(['middleware' => 'permission:manage_proposals'], function () {
            Route::get('proposals', 'ProposalController@index')->name('proposals.index');
            Route::post('proposals', 'ProposalController@store')->name('proposals.store');
            Route::get('proposals/create/{relatedTo?}', 'ProposalController@create')->name('proposals.create');
            Route::get('proposals/{proposal}/edit', 'ProposalController@edit')->name('proposals.edit');
            Route::post('proposals/{proposal}', 'ProposalController@update')->name('proposals.update');
            Route::delete('proposals/{proposal}', 'ProposalController@destroy')->name('proposals.destroy');
            Route::get('proposals/{proposal}', 'ProposalController@show')->name('proposals.show');
            Route::put('proposals/{proposal}/change-status',
                'ProposalController@changeStatus')->name('proposal.change-status');
            Route::get('proposals/{proposal}/view-as-customer',
                'ProposalController@viewAsCustomer')->name('proposal.view-as-customer');
            Route::get('proposals/{proposal}/pdf', 'ProposalController@convertToPdf')->name('proposal.pdf');
            Route::post('proposals/{proposal}/convert-to-invoice',
                'ProposalController@convertToInvoice')->name('proposal.convert-to-invoice');
            Route::post('proposals/{proposal}/convert-to-estimate',
                'ProposalController@convertToEstimate')->name('proposal.convert-to-estimate');
            Route::get('proposals/{proposal}/{group}', 'ProposalController@show')->name('proposals.show');
        });

        // Credit Notes routes
        Route::group(['middleware' => 'permission:manage_credit_notes'], function () {
            Route::get('credit-notes', 'CreditNoteController@index')->name('credit-notes.index');
            Route::post('credit-notes', 'CreditNoteController@store')->name('credit-notes.store');
            Route::get('credit-notes/create/{customerId?}', 'CreditNoteController@create')->name('credit-notes.create');
            Route::get('credit-notes/{creditNote}/edit', 'CreditNoteController@edit')->name('credit-notes.edit');
            Route::post('credit-notes/{creditNote}', 'CreditNoteController@update')->name('credit-notes.update');
            Route::delete('credit-notes/{creditNote}', 'CreditNoteController@destroy')->name('credit-notes.destroy');
            Route::get('credit-notes/{creditNote}', 'CreditNoteController@show')->name('credit-notes.show');

            Route::put('credit-notes/{creditNote}/change-payment-status',
                'CreditNoteController@changePaymentStatus')->name('credit-note.change-payment-status');
            Route::get('credit-notes/{creditNote}/view-as-customer',
                'CreditNoteController@viewAsCustomer')->name('credit-note.view-as-customer');
            Route::get('credit-notes/{creditNote}/pdf', 'CreditNoteController@convertToPdf')->name('credit-note.pdf');
        });

        // Email Template routes
//    Route::get('email-templates', 'EmailTemplateController@index')->name('email-templates.index');
//    Route::get('email-templates/{email_template}/edit', 'EmailTemplateController@edit')->name('email-templates.edit');
//    Route::put('email-templates/{email_template}', 'EmailTemplateController@update')->name('email-templates.update');
//    Route::post('email-templates/{email_template}/enable-disable', 'EmailTemplateController@enableDisableTemplate');

        // settings routes
        Route::group(['middleware' => 'permission:manage_settings'], function () {
            Route::get('settings', 'SettingController@show')->name('settings.show');
            Route::post('settings', 'SettingController@update')->name('settings.update');
        });

        // Menu settings
//    Route::get('menu-settings', 'MenuSettingController@index')->name('menu-settings.index');
        // Activity Log
        Route::get('activity-logs', 'ActivityLogController@index')->name('activity.logs.index');
    });

Route::group(['middleware' => ['auth', 'xss', 'checkUserStatus'], 'prefix' => 'admin'], function () {

    // Dashboard route
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    // Tasks routes
    Route::group(['middleware' => 'permission:manage_tasks'], function () {
        Route::get('tasks', 'TaskController@index')->name('tasks.index');
        Route::get('tasks/create/{relatedTo?}/{customerId?}', 'TaskController@create')->name('tasks.create');
        Route::post('tasks', 'TaskController@store')->name('tasks.store');
        Route::get('tasks/{task}', 'TaskController@show')->name('tasks.show');
        Route::get('tasks/{task}/edit', 'TaskController@edit')->name('tasks.edit');
        Route::put('tasks/{task}', 'TaskController@update')->name('tasks.update');
        Route::delete('tasks/{task}', 'TaskController@destroy')->name('tasks.destroy');
        Route::get('change-owner', 'TaskController@changeOwner')->name('change-owner');
//        Route::get('tasks-list', 'TaskController@tasksList')->name('tasks.tasksList');
        Route::put('tasks/{task}/status/{status}', 'TaskController@changeStatus')->name('tasks.changeStatus');
        Route::get('tasks-kanban-list', 'TaskController@kanbanList')->name('tasks.kanbanList');
        Route::get('tasks/{task}/comments-count', 'TaskController@getCommentsCount')->name('task.comments-count');
        Route::get('tasks/{task}/{group}', 'TaskController@show')->name('tasks.show');
    });

    // Projects routes
    Route::group(['middleware' => 'permission:manage_projects'], function () {
        Route::get('projects', 'ProjectController@index')->name('projects.index');
        Route::post('projects', 'ProjectController@store')->name('projects.store');
        Route::get('projects/create/{customerId?}', 'ProjectController@create')->name('projects.create');
        Route::put('projects/{project}', 'ProjectController@update')->name('projects.update');
        Route::get('projects/{project}', 'ProjectController@show')->name('projects.show');
        Route::delete('projects/{project}', 'ProjectController@destroy')->name('projects.destroy');
        Route::get('projects/{project}/edit', 'ProjectController@edit')->name('projects.edit');
        Route::post('member-as-per-customer',
            'ProjectController@memberAsPerCustomer')->name('projects.memberAsPerCustomer');
        Route::get('projects/{project}/{group}', 'ProjectController@show')->name('projects.show');
    });

    // Tickets routes
    Route::group(['middleware' => 'permission:manage_tickets'], function () {
        Route::get('tickets', 'TicketController@index')->name('ticket.index');
        Route::get('tickets/create', 'TicketController@create')->name('ticket.create');
        Route::post('tickets', 'TicketController@store')->name('ticket.store');
        Route::get('tickets/{ticket}', 'TicketController@show')->name('ticket.show');
        Route::get('tickets/{ticket}/edit', 'TicketController@edit')->name('ticket.edit');
        Route::put('tickets/{ticket}', 'TicketController@update')->name('ticket.update');
        Route::delete('tickets/{ticket}', 'TicketController@destroy')->name('ticket.destroy');
        Route::get('tickets/predefinedReplyBody/{predefinedReplyId?}',
            'TicketController@getPredefinedReplyBody')->name('ticket.reply.body');
        Route::get('tickets-attachment-download/{ticket}', 'TicketController@downloadMedia');
        Route::get('tickets/{ticket}/{group}', 'TicketController@show')->name('tickets.show');
        Route::get('tickets/{ticket}/{group}/notes-count',
            'TicketController@getNotesCount')->name('ticket.notes-count');
        Route::get('tickets-kanban-list', 'TicketController@kanbanList')->name('tickets.kanbanList');
        Route::put('tickets/{ticket}/status/{statusId}',
            'TicketController@changeStatus')->name('tickets.changeStatus');
        Route::delete('ticket-attachment-delete', 'TicketController@attachmentDelete')->name('ticket.attachment');
        Route::get('download-media/{mediaItem}', 'TicketController@download')->name('ticket.download.media');
    });

    // Ticket Priorities routes
    Route::group(['middleware' => 'permission:manage_ticket_priority'], function () {
        Route::get('ticket-priorities', 'TicketPriorityController@index')->name('ticketPriorities.index');
        Route::post('ticket-priorities', 'TicketPriorityController@store')->name('ticketPriorities.store');
        Route::get('ticket-priorities/{ticketPriority}/edit',
            'TicketPriorityController@edit')->name('ticketPriorities.edit');
        Route::put('ticket-priorities/{ticketPriority}',
            'TicketPriorityController@update')->name('ticketPriorities.update');
        Route::delete('ticket-priorities/{ticketPriority}',
            'TicketPriorityController@destroy')->name('ticketPriorities.destroy');
        Route::post('ticket-priorities/{ticket_priority_id}/active-deactive',
            'TicketPriorityController@activeDeActiveCategory')->name('active.deactive');
    });

    // Ticket Status routes
    Route::group(['middleware' => 'permission:manage_ticket_statuses'], function () {
        Route::get('ticket-statuses', 'TicketStatusController@index')->name('ticket.status.index');
        Route::post('ticket-statuses', 'TicketStatusController@store')->name('ticket.status.store');
        Route::get('ticket-statuses/{ticketStatus}/edit',
            'TicketStatusController@edit')->name('ticket.status.edit');
        Route::put('ticket-statuses/{ticketStatus}',
            'TicketStatusController@update')->name('ticket.status.update');
        Route::delete('ticket-statuses/{ticketStatus}',
            'TicketStatusController@destroy')->name('ticket.status.destroy');
    });

    // Payment Modes routes
    Route::group(['middleware' => 'permission:manage_payment_mode'], function () {
        Route::get('payment-modes', 'PaymentModeController@index')->name('payment-modes.index');
        Route::post('payment-modes', 'PaymentModeController@store')->name('payment-modes.store');
        Route::get('payment-modes/{paymentMode}/edit', 'PaymentModeController@edit')->name('payment-modes.edit');
        Route::put('payment-modes/{paymentMode}', 'PaymentModeController@update')->name('payment-modes.update');
        Route::delete('payment-modes/{paymentMode}',
            'PaymentModeController@destroy')->name('payment-modes.destroy');
        Route::post('payment-modes/{paymentMode}/active-deactive',
            'PaymentModeController@activeDeActivePaymentMode');
        Route::get('payment-modes/{paymentMode}', 'PaymentModeController@show')->name('payment-modes.show');
    });

    // Lead Sources route
    Route::group(['middleware' => 'permission:manage_lead_sources'], function () {
        Route::get('lead-sources', 'LeadSourceController@index')->name('lead.source.index');
        Route::post('lead-sources', 'LeadSourceController@store')->name('lead.source.store');
        Route::get('lead-sources/{leadSource}/edit', 'LeadSourceController@edit')->name('lead.source.edit');
        Route::put('lead-sources/{leadSource}', 'LeadSourceController@update')->name('lead.source.update');
        Route::delete('lead-sources/{leadSource}', 'LeadSourceController@destroy')->name('lead.source.destroy');
    });

    // Lead Status routes
    Route::group(['middleware' => 'permission:manage_lead_status'], function () {
        Route::get('lead-status', 'LeadStatusController@index')->name('lead.status.index');
        Route::post('lead-status', 'LeadStatusController@store')->name('lead.status.store');
        Route::get('lead-status/{leadStatus}/edit', 'LeadStatusController@edit')->name('lead.status.edit');
        Route::put('lead-status/{leadStatus}', 'LeadStatusController@update')->name('lead.status.update');
        Route::delete('lead-status/{leadStatus}', 'LeadStatusController@destroy')->name('lead.status.destroy');
    });

    // Invoices routes
    Route::group(['middleware' => 'permission:manage_invoices'], function () {
        Route::get('invoices', 'InvoiceController@index')->name('invoices.index');
        Route::post('invoices', 'InvoiceController@store')->name('invoices.store');
        Route::get('invoices/create/{customerId?}', 'InvoiceController@create')->name('invoices.create');
        Route::get('invoices/{invoice}/edit', 'InvoiceController@edit')->name('invoices.edit');
        Route::post('invoices/{invoice}', 'InvoiceController@update')->name('invoices.update');
        Route::delete('invoices/{invoice}', 'InvoiceController@destroy')->name('invoices.destroy');
        Route::get('invoices/{invoice}', 'InvoiceController@show')->name('invoices.show');
        Route::get('invoices/{invoice}/view-as-customer',
            'InvoiceController@viewAsCustomer')->name('invoice.view-as-customer');
        Route::get('invoices/{invoice}/pdf', 'InvoiceController@covertToPdf')->name('invoice.pdf');
        Route::put('invoices/{invoice}/change-status', 'InvoiceController@changeStatus')->name('invoice.change-status');
        Route::get('invoices/{invoice}/{group}', 'InvoiceController@show')->name('invoices.show');
        Route::get('invoices/{invoice}/{group}/notes-count',
            'InvoiceController@getNotesCount')->name('ticket.notes-count');
    });
    Route::get('customer-address', 'InvoiceController@getCustomerAddress')->name('get.customer.address');
    Route::get('credit-note-customer-address', 'CreditNoteController@getCustomerAddress')->name('get.creditnote.customer.address');
    Route::get('estimates-customer-address', 'EstimateController@getCustomerAddress')->name('get.estimate.customer.address');
    Route::get('proposal-customer-address', 'ProposalController@getCustomerAddress')->name('get.proposal.customer.address');

    // Payments routes
    Route::group(['middleware' => 'permission:manage_payments'], function () {
        Route::get('payments', 'PaymentController@index')->name('payments.index');
        Route::post('payments', 'PaymentController@store')->name('payments.store');
        Route::delete('payments/{payment}', 'PaymentController@destroy')->name('payments.destroy');
        Route::get('payments/edit', 'PaymentController@addPayment')->name('payments.create');
    });

    // Payment for Invoices routes
    Route::group(['namespace' => 'Listing'], function () {
        Route::get('payments-list', 'PaymentListing@index')->name('payments.list.index');
        Route::get('payment-details/{payment?}', 'PaymentListing@show')->name('payments.list.show');
    });

    // Estimates routes
    Route::group(['middleware' => 'permission:manage_estimates'], function () {
        Route::get('estimates', 'EstimateController@index')->name('estimates.index');
        Route::get('estimates/create/{customerId?}', 'EstimateController@create')->name('estimates.create');
        Route::post('estimates', 'EstimateController@store')->name('estimates.store');
        Route::get('estimates/{estimate}/edit', 'EstimateController@edit')->name('estimates.edit');
        Route::post('estimates/{estimate}', 'EstimateController@update')->name('estimates.update');
        Route::delete('estimates/{estimate}', 'EstimateController@destroy')->name('estimates.destroy');
        Route::get('estimates/{estimate}', 'EstimateController@show')->name('estimates.show');
        Route::put('estimates/{estimate}/change-status',
            'EstimateController@changeStatus')->name('estimate.change-status');
        Route::get('estimates/{estimate}/view-as-customer',
            'EstimateController@viewAsCustomer')->name('estimate.view-as-customer');
        Route::get('estimates/{estimate}/pdf', 'EstimateController@convertToPdf')->name('estimate.pdf');
        Route::post('estimates/{estimate}/convert-to-invoice',
            'EstimateController@convertToInvoice')->name('estimate.convert-to-invoice');
        Route::get('estimates/{estimate}/{group}', 'EstimateController@show')->name('estimates.show');
    });

    // Profile routes
    Route::post('change-password', 'UserController@changePassword')->name('change.password');
    Route::get('profile', 'UserController@editProfile')->name('profile');
    Route::post('update-profile', 'UserController@updateProfile')->name('update.profile');
    Route::post('change-language', 'UserController@changeLanguage')->name('change.language');

});

Route::group(['middleware' => ['auth', 'xss', 'checkUserStatus', 'role:client'], 'prefix' => 'client'], function () {

    Route::get('dashboard', 'Clients\DashboardController@index')->name('clients.dashboard');

    // Projects routes
    Route::group(['middleware' => 'permission:contact_projects'], function () {
        Route::get('projects', 'Clients\ProjectController@index')->name('clients.projects.index');
        Route::get('projects/{project}', 'Clients\ProjectController@show')->name('clients.projects.show');
        Route::get('projects/{project}/{group}', 'Clients\ProjectController@show')->name('clients.projects.show');
    });

    // Tasks routes
    Route::get('tasks', 'Clients\TaskController@index')->name('clients.tasks.index');
    Route::get('tasks/{task}', 'Clients\TaskController@show')->name('clients.tasks.show');
    Route::get('tasks/{task}/{group}', 'Clients\TaskController@show')->name('clients.tasks.show');

    // Reminder routes
    Route::get('reminder', 'Clients\ReminderController@index')->name('clients.reminder.index');

    // Invoices routes
    Route::group(['middleware' => 'permission:contact_invoices'], function () {
        Route::get('invoices', 'Clients\InvoiceController@index')->name('clients.invoices.index');
        Route::get('invoices/{invoice}/view-as-customer',
            'Clients\InvoiceController@viewAsCustomer')->name('clients.invoices.view-as-customer');
        Route::get('invoices/{invoice}/pdf', 'InvoiceController@covertToPdf')->name('clients.invoice.pdf');
        Route::post('invoice-stripe-payment', 'PaymentController@createSession');
        Route::get('invoice-payment-success',
            'PaymentController@paymentSuccess')->name('clients.invoice-payment-success');
        Route::get('invoice-failed-payment',
            'PaymentController@handleFailedPayment')->name('clients.invoice-failed-payment');
    });

    // Proposals routes
    Route::group(['middleware' => 'permission:contact_proposals'], function () {
        Route::get('proposals', 'Clients\ProposalController@index')->name('clients.proposals.index');
        Route::get('proposals/{proposal}/view-as-customer',
            'Clients\ProposalController@viewAsCustomer')->name('clients.proposals.view-as-customer');
        Route::post('proposals/{proposal}/change-status',
            'Clients\ProposalController@changeStatus')->name('clients.proposals.change-status');
        Route::get('proposals/{proposal}/pdf', 'Clients\ProposalController@covertToPdf')->name('clients.proposal.pdf');
    });

    // Contracts routes
    Route::group(['middleware' => 'permission:contact_contracts'], function () {
        Route::get('contracts', 'Clients\ContractController@index')->name('clients.contracts.index');
        Route::get('contracts/{contract}/view-as-customer', 'Clients\ContractController@viewAsCustomer')
            ->name('clients.contracts.view-as-customer');
        Route::get('contracts/{contract}/pdf',
            'Clients\ContractController@convertToPdf')->name('clients.contracts.pdf');
    });

    // Estimates routes
    Route::group(['middleware' => 'permission:contact_estimates'], function () {
        Route::get('estimates', 'Clients\EstimateController@index')->name('clients.estimates.index');
        Route::get('estimates/{estimate}/view-as-customer', 'Clients\EstimateController@viewAsCustomer')
            ->name('clients.estimates.view-as-customer');
        Route::get('estimates/{estimate}/pdf', 'Clients\EstimateController@convertToPDF')->name('clients.estimate.pdf');
        Route::post('estimates/{estimate}/change-status', 'Clients\EstimateController@changeStatus')
            ->name('clients.estimates.change-status');
    });

    // Announcements routes 
    Route::get('announcements', 'Clients\AnnouncementController@index')->name('clients.announcements.index');
    Route::get('announcements/{announcement}',
        'Clients\AnnouncementController@show')->name('clients.announcements.show');

    // Company Details Routes
    Route::get('company-details', 'Clients\CompanyController@companyDetails')->name('clients.company-details');
    Route::put('company-details/{customer}', 'Clients\CompanyController@update')->name('clients.update');

    // Profile routes
    Route::post('change-password', 'Clients\UserController@changePassword')->name('clients.change.password');
    Route::get('profile', 'Clients\UserController@editProfile')->name('clients.profile');
    Route::post('update-profile', 'Clients\UserController@updateProfile')->name('clients.update.profile');
    Route::post('change-language', 'Clients\UserController@changeLanguage')->name('clients.change.language');

});

Route::get('article-search', function () {
    return view('articles.search');
});

Route::get('kanban', function () {
});

