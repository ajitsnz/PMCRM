<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Str;

/**
 * App\Models\CreditNote
 *
 * @property int $id
 * @property int $customer_id
 * @property string $credit_note_number
 * @property Carbon $credit_note_date
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
 * @property-read Collection|CreditNoteAddress[] $creditNoteAddresses
 * @property-read int|null $credit_note_addresses_count
 * @property-read Customer $customer
 * @property-read Collection|SalesItem[] $salesItems
 * @property-read int|null $sales_items_count
 * @property-read Collection|SalesTax[] $salesTaxes
 * @property-read int|null $sales_taxes_count
 * @method static Builder|CreditNote newModelQuery()
 * @method static Builder|CreditNote newQuery()
 * @method static Builder|CreditNote query()
 * @method static Builder|CreditNote whereAdjustment($value)
 * @method static Builder|CreditNote whereAdminText($value)
 * @method static Builder|CreditNote whereClientNote($value)
 * @method static Builder|CreditNote whereCreatedAt($value)
 * @method static Builder|CreditNote whereCreditNoteDate($value)
 * @method static Builder|CreditNote whereCreditNoteNumber($value)
 * @method static Builder|CreditNote whereCurrency($value)
 * @method static Builder|CreditNote whereCustomerId($value)
 * @method static Builder|CreditNote whereDiscount($value)
 * @method static Builder|CreditNote whereDiscountType($value)
 * @method static Builder|CreditNote whereId($value)
 * @method static Builder|CreditNote wherePaymentStatus($value)
 * @method static Builder|CreditNote whereSubTotal($value)
 * @method static Builder|CreditNote whereTermConditions($value)
 * @method static Builder|CreditNote whereTotalAmount($value)
 * @method static Builder|CreditNote whereUnit($value)
 * @method static Builder|CreditNote whereUpdatedAt($value)
 * @mixin Model
 * @property string|null $reference
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditNote whereReference($value)
 */
class CreditNote extends Model implements \App\Models\Contracts\Taggable
{
    const UNIT_MEASURES = [
        1 => 'Quantity',
        2 => 'Hours',
        3 => 'Qty/Hours',
    ];

    const PAYMENT_STATUS = [
        0 => 'Drafted',
        1 => 'Open',
        2 => 'Void',
        3 => 'Closed',
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'danger',
        2 => 'primary',
        3 => 'success',
    ];

    const PAYMENT_STATUS_DRAFT = 0;
    const PAYMENT_STATUS_OPEN = 1;
    const PAYMENT_STATUS_VOID = 2;
    const PAYMENT_STATUS_CLOSED = 3;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title'               => 'required',
        'customer_id'         => 'required',
        'credit_note_number'  => 'required',
        'credit_note_date'    => 'required',
        'currency'            => 'required',
        'discount_type'       => 'required',
        'unit'                => 'required',
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
        'itemsArr.required'            => 'Atleast one product is required.',
        'itemsArr.*.item.required'     => 'Product field is required.',
        'itemsArr.*.quantity.required' => 'Quantity field is required',
        'itemsArr.*.rate.required'     => 'Rate field is required',

    ];

    public $table = 'credit_notes';

    public $fillable = [
        'customer_id',
        'title',
        'credit_note_number',
        'credit_note_date',
        'sales_agent_id',
        'currency',
        'discount_type',
        'reference',
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
        'id'                 => 'integer',
        'title'              => 'string',
        'customer_id'        => 'integer',
        'credit_note_number' => 'string',
        'credit_note_date'   => 'datetime',
        'currency'           => 'integer',
        'discount_type'      => 'integer',
        'reference'          => 'string',
        'admin_text'         => 'string',
        'total_amount'       => 'double',
        'sub_total'          => 'double',
        'discount'           => 'double',
        'adjustment'         => 'double',
        'discount_symbol'    => 'integer',
    ];

    /**
     * @return string
     */
    public static function generateUniqueCreditNoteId()
    {
        $creditNoteId = mb_strtoupper(Str::random(6));
        while (true) {
            $isExist = CreditNote::whereCreditNoteNumber($creditNoteId)->exists();
            if ($isExist) {
                self::generateUniqueCreditNoteId();
            }
            break;
        }

        return $creditNoteId;
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
     * @return HasMany
     */
    public function creditNoteAddresses()
    {
        return $this->hasMany(CreditNoteAddress::class);
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
        return CreditNote::class;
    }

    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
     * @param  int  $discountTypeId
     *
     * @return mixed
     */
    public function getDiscountTypeText($discountTypeId)
    {
        return $this->discountType()[$discountTypeId];
    }

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
}
