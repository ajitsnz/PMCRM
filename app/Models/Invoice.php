<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Str;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property int $customer_id
 * @property string $invoice_number
 * @property Carbon $invoice_date
 * @property Carbon|null $due_date
 * @property int|null $sales_agent_id
 * @property int $currency
 * @property int|null $discount_type
 * @property float|null $discount
 * @property string|null $admin_text
 * @property int $unit
 * @property string|null $client_note
 * @property string|null $term_conditions
 * @property float|null $sub_total
 * @property float $adjustment
 * @property float|null $total_amount
 * @property int|null $payment_status
 * @property int|null $discount_symbol
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceAddress[] $invoiceAddresses
 * @property-read int|null $invoice_addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentMode[] $paymentModes
 * @property-read int|null $payment_modes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesItem[] $salesItems
 * @property-read int|null $sales_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesTax[] $salesTaxes
 * @property-read int|null $sales_taxes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereAdjustment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereAdminText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereClientNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereSalesAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereTermConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model implements \App\Models\Contracts\Taggable
{
    const UNIT_MEASURES = [
        1 => 'Quantity',
        2 => 'Hours',
        3 => 'Qty/Hours',
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'primary',
        2 => 'success',
        3 => 'info',
        4 => 'danger',
    ];

    const PAYMENT_STATUS = [
        0 => 'Drafted',
        1 => 'Unpaid',
        2 => 'Paid',
        3 => 'Partially Paid',
        4 => 'Cancelled',
    ];

    const STATUS_DRAFT = 0;
    const STATUS_UNPAID = 1;
    const STATUS_PAID = 2;
    const STATUS_PARTIALLY_PAID = 3;
    const STATUS_CANCELLED = 4;

    const CLIENT_PAYMENT_STATUS = [
        1 => 'Unpaid',
        2 => 'Paid',
        3 => 'Partially Paid',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title'               => 'required',
        'customer_id'         => 'required',
        'invoice_number'      => 'required',
        'invoice_date'        => 'required',
        'currency'            => 'required',
        'unit'                => 'required',
        'discount_type'       => 'required',
        'payment_modes'       => 'required',
        'itemsArr'            => 'required|array',
        'itemsArr.*.item'     => 'required',
        'itemsArr.*.quantity' => 'required',
        'itemsArr.*.rate'     => 'required',
    ];

    /**
     * @var array
     */
    public static $messages = [
        'customer_id.required'         => 'Customer field is required.',
        'payment_modes.required'       => 'Payment Mode field is required.',
        'itemsArr.required'            => 'Atleast one product is required.',
        'itemsArr.*.item.required'     => 'Product field is required.',
        'itemsArr.*.quantity.required' => 'Quantity field is required',
        'itemsArr.*.rate.required'     => 'Rate field is required',

    ];

    public $table = 'invoices';

    public $fillable = [
        'title',
        'customer_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'sales_agent_id',
        'currency',
        'discount_type',
        'admin_text',
        'unit',
        'client_note',
        'term_conditions',
        'total_amount',
        'sub_total',
        'discount',
        'adjustment',
        'payment_status',
        'discount_symbol',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'              => 'integer',
        'title'           => 'string',
        'customer_id'     => 'integer',
        'invoice_number'  => 'string',
        'invoice_date'    => 'date',
        'due_date'        => 'date',
        'sales_agent_id'  => 'integer',
        'currency'        => 'integer',
        'discount_type'   => 'integer',
        'admin_text'      => 'string',
        'total_amount'    => 'double',
        'sub_total'       => 'double',
        'discount'        => 'double',
        'adjustment'      => 'double',
        'payment_status'  => 'integer',
        'discount_symbol' => 'integer',
    ];

    /**
     * @return array
     */
    public static function discountType()
    {
        return $discountType = [
            '0' => 'No Discount',
            '1' => 'Before Tax',
            '2' => 'After Tax',
        ];
    }

    /**
     * @return string
     */
    public static function generateUniqueInvoiceId()
    {
        $invoiceId = mb_strtoupper(Str::random(6));
        while (true) {
            $isExist = Invoice::whereInvoiceNumber($invoiceId)->exists();
            if ($isExist) {
                self::generateUniqueInvoiceId();
            }
            break;
        }

        return $invoiceId;
    }

    /**
     * @return HasMany
     */
    public function invoiceAddresses()
    {
        return $this->hasMany(InvoiceAddress::class);
    }

    /**
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return BelongsToMany
     */
    public function paymentModes()
    {
        return $this->belongsToMany(
            PaymentMode::class, 'invoice_payment_modes', 'invoice_id', 'payment_mode_id');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOwnerType()
    {
        return Invoice::class;
    }

    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }

    /**
     * @return MorphMany
     */
    public function salesItems()
    {
        return $this->morphMany(SalesItem::class, 'owner');
    }

    /**
     * @return MorphToMany
     */
    public function salesTaxes()
    {
        return $this->morphMany(SalesTax::class, 'owner');
    }

    /**
     * @param  int  $currencyId
     *
     * @return mixed
     */
    public static function getCurrencyText($currencyId)
    {
        return Customer::CURRENCIES[$currencyId];
    }

    /**
     * @param  int  $discountTypeId
     *
     * @return mixed
     */
    public function getDiscountTypeText($discountTypeId)
    {
        return $this->discountType()[$discountTypeId];
    }

    /**
     * @return mixed
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'owner');
    }

    /**
     *
     * @return HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'owner_id');
    }
}
