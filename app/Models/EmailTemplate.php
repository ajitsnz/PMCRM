<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class EmailTemplate
 *
 * @package App\Models
 * @version April 24, 2020, 5:40 am UTC
 * @property int $id
 * @property string $template_name
 * @property string|null $subject
 * @property string $from_name
 * @property int $send_plain_text
 * @property int $disabled
 * @property string $email_message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereEmailMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereSendPlainText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereTemplateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $template_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereTemplateType($value)
 */
class EmailTemplate extends Model
{
    const DISABLED_TEMPLATE_ARR = [
        1 => 'Enabled',
        0 => 'Disabled',
    ];

    const TEMPLATE_TYPES = [
        '1'  => 'Tickets',
        '2'  => 'Estimates',
        '3'  => 'Contracts',
        '4'  => 'Invoices',
        '5'  => 'Subscriptions',
        '6'  => 'Credit Note',
        '7'  => 'Tasks',
        '8'  => 'Customers',
        '9'  => 'Proposals',
        '10' => 'Projects',
        '11' => 'Staff Members',
        '12' => 'Leads',
        '13' => 'General Data Protection Regulation (GDPR)',
    ];
    const MERGE_FIELDS = [
        'Client' => [
            'contact_firstname'       => 'Contact Firstname',
            'contact_lastname'        => 'Contact Lastname',
            'contact_phonenumber'     => 'Contact Phone Number',
            'contact_title'           => 'Contact Title',
            'contact_email'           => 'Contact Email',
            'client_company'          => 'Client Company',
            'client_phonenumber'      => 'Client Phone Number',
            'client_country'          => 'Client Country',
            'client_city'             => 'Client City',
            'client_zip'              => 'Client Zip',
            'client_state'            => 'Client State',
            'client_address'          => 'Client Address',
            'client_vat_number'       => 'Client Vat Number',
            'client_id'               => 'Client ID',
            'customers_vergi_dairesi' => 'Vergi Dairesi',
        ],
        'Ticket'       => [
            'ticket_id'               => 'Ticket ID',
            'ticket_url'              => 'Ticket Customers Area URL',
            'ticket_public_url'       => 'Ticket Public URL',
            'ticket_department'       => 'Department',
            'ticket_department_email' => 'Department Email',
            'ticket_date'             => 'Date Opened',
            'ticket_subject'          => 'Ticket Subject',
            'ticket_message'          => 'Ticket Message',
            'ticket_status'           => 'Ticket Status',
            'ticket_priority'         => 'Ticket Priority',
            'ticket_service'          => 'Ticket Service',
        ],
        'Estimate'     => [
            'estimate_id'         => 'Estimate ID',
            'estimate_number'     => 'Estimate Number',
            'estimate_link'       => 'Estimate Link',
            'estimate_status'     => 'Estimate status',
            'estimate_expirydate' => 'Estimate Expiry Date',
        ],
        'Contract'     => [
            'contract_id'          => 'Contract ID',
            'contract_description' => 'Contract Description',
            'contract_subject'     => 'Contract Subject',
            'contract_dateend'     => 'Contract Date End',
            'contract_datestart'   => 'Contract Date Start',
            'contract_link'        => 'Contract Link',
        ],
        'Invoice'      => [
            'invoice_id'      => 'Invoice ID',
            'invoice_number'  => 'Invoice Number',
            'invoice_link'    => 'Invoice Link',
            'invoice_status'  => 'Invoice Status',
            'payment_total'   => 'Payment Total',
            'payment_date'    => 'Payment Date',
            'invoice_duedate' => 'Invoice Due Date',
        ],
        'Subscription' => [
            'subscription_id'                     => 'Subscriptions ID',
            'subscription_name'                   => 'Subscriptions Name',
            'subscription_link'                   => 'Subscriptions Link',
            'subscription_description'            => 'Subscriptions Description',
            'subscription_authorize_payment_link' => 'Subscriptions Authorize Payment Link',
            'invoice_status'                      => 'Invoice Status',
            'payment_total'                       => 'Payment Total',
        ],
        'Credit Note'  => [
            'credit_note_id'     => 'Credit Note ID',
            'credit_note_number' => 'Credit Note Number',
            'credit_note_total'  => 'Credit Note Total',
            'credit_note_date'   => 'Credit Note Date',
        ],
        'Task'         => [
            'task_id'               => 'Task ID',
            'task_name'             => 'Task Name',
            'task_duedate'          => 'Task Due Date',
            'task_startdate'        => 'Task Start Date',
            'task_priority'         => 'Task Priority',
            'task_link'             => 'Task Link',
            'task_comment'          => 'Task Comment',
            'task_status'           => 'Task Status',
            'task_user_take_action' => 'Task User Take Action',
        ],
        'Customer'     => [
            'customer_id'                       => 'Customer ID',
            'reset_password_url'                => 'Reset Password URL',
            'statement_to'                      => 'Statement To',
            'statement_from'                    => 'Statement From',
            'statement_balance_due'             => 'Statement Balance Due',
            'customer_profile_files_admin_link' => 'Customer Profile Files Admin Link',
        ],
        'Proposal'     => [
            'proposal_id'          => 'Proposal ID',
            'proposal_number'      => 'Proposal Number',
            'proposal_subject'     => 'Proposal Subject',
            'proposal_link'        => 'Proposal Link',
            'proposal_open_till'   => 'Proposal Open Till',
            'proposal_proposal_to' => 'Proposal Proposal To',
        ],
        'Project'      => [
            'project_id'             => 'Project ID',
            'project_name'           => 'Project Name',
            'project_start_date'     => 'Project Start Date',
            'discussion_creator'     => 'Discussion Creator',
            'discussion_subject'     => 'Discussion Subject',
            'discussion_description' => 'Discussion Description',
            'discussion_comment'     => 'Discussion Comment',
            'discussion_link'        => 'Discussion Link',
            'project_link'           => 'Project Link',
            'file_creator'           => 'File Creator',
            'comment_creator'        => 'Comment Creator',
        ],
        'Staff Member' => [
            'staff_member_id'              => 'Staff Member ID',
            'project_name'                 => 'Project Name',
            'password'                     => 'Password',
            'reset_password_url'           => 'Reset Password URL',
            'staff_email'                  => 'Staff Email',
            'staff_reminder_relation_link' => 'Staff Reminder Relation Link',
            'staff_reminder_description'   => 'Staff Reminder Description',
            'event_start_date'             => 'Event Start Date',
            'event_title'                  => 'Event Title',
        ],
        'Lead'         => [
            'lead_assigned' => 'Lead Assigned',
            'lead_name'     => 'Lead Name',
            'lead_link'     => 'Lead Link',
            'lead_email'    => 'Lead Email',
        ],

        'Other'  => [
            'logo_url'                 => 'Logo URL',
            'logo_image_with_url'      => 'Logo image with URL',
            'dark_logo_image_with_url' => 'Dark logo image with URL',
            'crm_url'                  => 'CRM URL',
            'admin_url'                => 'Admin URL',
            'main_domain'              => 'Main Domain{main_domain',
            'companyname'              => 'Company Name',
            'email_signature'          => 'Email Signature',
            'terms_and_conditions_url' => '(GDPR) Terms & Conditions URL',
            'privacy_policy_url'       => '(GDPR) Privacy Policy URL',
            'staff_firstname'          => 'Staff First Name',
            'staff_lastname'           => 'Staff Last Name',
        ],
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'template_name' => 'required',
        'from_name'     => 'required',
        'email_message' => 'required',
    ];
    public $table = 'email_templates';
    public $fillable = [
        'template_name',
        'template_type',
        'subject',
        'from_name',
        'send_plain_text',
        'disabled',
        'email_message',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
