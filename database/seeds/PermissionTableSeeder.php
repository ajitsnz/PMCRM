<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'         => 'manage_customer_groups',
                'type'         => 'Customers',
                'display_name' => 'Manage Customer Groups',
            ],
            [
                'name'         => 'manage_customers',
                'type'         => 'Customers',
                'display_name' => 'Manage Customers',
            ],
            [
                'name'         => 'manage_staff_member',
                'type'         => 'Members',
                'display_name' => 'Manage Staff Member',
            ],
            [
                'name'         => 'manage_article_groups',
                'type'         => 'Articles',
                'display_name' => 'Manage Article Groups',
            ],
            [
                'name'         => 'manage_articles',
                'type'         => 'Articles',
                'display_name' => 'Manage Articles',
            ],
            [
                'name'         => 'manage_tags',
                'type'         => 'Tags',
                'display_name' => 'Manage Tags',
            ],
            [
                'name'         => 'manage_leads',
                'type'         => 'Leads',
                'display_name' => 'Manage Leads',
            ],
            [
                'name'         => 'manage_lead_status',
                'type'         => 'Leads',
                'display_name' => 'Manage Lead Status',
            ],
            [
                'name'         => 'manage_tasks',
                'type'         => 'Tasks',
                'display_name' => 'Manage Tasks',
            ],
            [
                'name'         => 'manage_ticket_priority',
                'type'         => 'Tickets',
                'display_name' => 'Manage Ticket Priority',
            ],
            [
                'name'         => 'manage_ticket_statuses',
                'type'         => 'Tickets',
                'display_name' => 'Manage Ticket Statuses',
            ],
            [
                'name'         => 'manage_tickets',
                'type'         => 'Tickets',
                'display_name' => 'Manage Tickets',
            ],
            [
                'name'         => 'manage_invoices',
                'type'         => 'Invoices',
                'display_name' => 'Manage Invoices',
            ],
            [
                'name'         => 'manage_payments',
                'type'         => 'Payments',
                'display_name' => 'Manage Payments',
            ],
            [
                'name'         => 'manage_payment_mode',
                'type'         => 'Payments',
                'display_name' => 'Manage Payment Mode',
            ],
            [
                'name'         => 'manage_credit_notes',
                'type'         => 'Credit Note',
                'display_name' => 'Manage Credit Note',
            ],
            [
                'name'         => 'manage_proposals',
                'type'         => 'Proposals',
                'display_name' => 'Manage Proposals',
            ],
            [
                'name'         => 'manage_estimates',
                'type'         => 'Estimates',
                'display_name' => 'Manage Estimates',
            ],
            [
                'name'         => 'manage_departments',
                'type'         => 'Departments',
                'display_name' => 'Manage Departments',
            ],
            [
                'name'         => 'manage_predefined_replies',
                'type'         => 'Predefined Replies',
                'display_name' => 'Manage Predefined Replies',
            ],
            [
                'name'         => 'manage_expense_category',
                'type'         => 'Expenses',
                'display_name' => 'Manage Expense Category',
            ],
            [
                'name'         => 'manage_expenses',
                'type'         => 'Expenses',
                'display_name' => 'Manage Expenses',
            ],
            [
                'name'         => 'manage_services',
                'type'         => 'Services',
                'display_name' => 'Manage Services',
            ],
            [
                'name'         => 'manage_items',
                'type'         => 'Items',
                'display_name' => 'Manage Items',
            ],
            [
                'name'         => 'manage_items_groups',
                'type'         => 'Items',
                'display_name' => 'Manage Items Groups',
            ],
            [
                'name'         => 'manage_tax_rates',
                'type'         => 'TaxRate',
                'display_name' => 'Manage Tax Rates',
            ],
            [
                'name'         => 'manage_announcements',
                'type'         => 'Announcements',
                'display_name' => 'Manage Announcements',
            ],
            [
                'name'         => 'manage_calenders',
                'type'         => 'Calenders',
                'display_name' => 'Manage Calenders',
            ],
            [
                'name'         => 'manage_lead_sources',
                'type'         => 'Leads',
                'display_name' => 'Manage Lead Sources',
            ],
            [
                'name'         => 'manage_contracts_types',
                'type'         => 'Contracts',
                'display_name' => 'Manage Contract Types',
            ],
            [
                'name'         => 'manage_contracts',
                'type'         => 'Contracts',
                'display_name' => 'Manage Contracts',
            ],
            [
                'name'         => 'manage_projects',
                'type'         => 'Projects',
                'display_name' => 'Manage Projects',
            ],
            [
                'name'         => 'manage_goals',
                'type'         => 'Goals',
                'display_name' => 'Manage Goals',
            ],
            [
                'name'         => 'manage_settings',
                'type'         => 'Settings',
                'display_name' => 'Manage Settings',
            ],
            [
                'name'         => 'contact_projects',
                'type'         => 'Contacts',
                'display_name' => 'Contact Projects',
            ],
            [
                'name'         => 'contact_invoices',
                'type'         => 'Contacts',
                'display_name' => 'Contact Invoices',
            ],
            [
                'name'         => 'contact_proposals',
                'type'         => 'Contacts',
                'display_name' => 'Contact Proposals',
            ],
            [
                'name'         => 'contact_contracts',
                'type'         => 'Contacts',
                'display_name' => 'Contact Contracts',
            ],
            [
                'name'         => 'contact_estimates',
                'type'         => 'Contacts',
                'display_name' => 'Contact Estimates',
            ],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
