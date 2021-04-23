<?php

namespace App\Models;

use App\Models\Contracts\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Class Estimate
 *
 * @package App\Models
 * @version April 27, 2020, 6:16 am UTC
 * @property int $id
 * @property string $title
 * @property int $customer_id
 * @property int $status
 * @property int $currency
 * @property string $estimate_number
 * @property string|null $reference
 * @property int|null $sales_agent_id
 * @property int|null $discount_type
 * @property Carbon $estimate_date
 * @property string $estimate_expiry_date
 * @property string|null $admin_note
 * @property float|null $discount
 * @property int $unit
 * @property float|null $sub_total
 * @property float $adjustment
 * @property float|null $total_amount
 * @property int|null $discount_symbol
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereAdjustment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereAdminNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereCurrency($value)
 *  * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereEstimateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereEstimateExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereEstimateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereSalesAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $client_note
 * @property string|null $term_conditions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereClientNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Estimate whereTermConditions($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EstimateAddress[] $estimateAddresses
 * @property-read int|null $estimate_addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesItem[] $salesItems
 * @property-read int|null $sales_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesTax[] $salesTaxes
 * @property-read int|null $sales_taxes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User|null $user
 */
class Estimate extends Model implements Taggable
{
    const UNIT_MEASURES = [
        1 => 'Quantity',
        2 => 'Hours',
        3 => 'Qty/Hours',
    ];

    const DISCOUNT_TYPES = [
        '0' => 'No Discount',
        '1' => 'Before Tax',
        '2' => 'After Tax',
    ];

    const STATUS = [
        '0' => 'Drafted',
        '1' => 'Sent',
        '2' => 'Expired',
        '3' => 'Declined',
        '4' => 'Accepted',
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'primary',
        2 => 'danger',
        3 => 'info',
        4 => 'success',
    ];

    const STATUS_DRAFT = 0;
    const STATUS_SEND = 1;
    const STATUS_EXPIRED = 2;
    const STATUS_DECLINED = 3;
    const STATUS_ACCEPTED = 4;

    const CLIENT_STATUS = [
        '1' => 'Sent',
        '2' => 'Expired',
        '3' => 'Declined',
        '4' => 'Accepted',
    ];

    public $table = 'estimates';

    public $fillable = [
        'title',
        'customer_id',
        'status',
        'currency',
        'estimate_number',
        'reference',
        'sales_agent_id',
        'discount_type',
        'estimate_date',
        'estimate_expiry_date',
        'admin_note',
        'discount',
        'unit',
        'sub_total',
        'adjustment',
        'total_amount',
        'client_note',
        'term_conditions',
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
        'estimate_number' => 'string',
        'estimate_date'   => 'datetime',
        'sales_agent_id'  => 'integer',
        'currency'        => 'integer',
        'discount_type'   => 'integer',
        'total_amount'    => 'double',
        'sub_total'       => 'double',
        'discount'        => 'double',
        'adjustment'      => 'double',
        'discount_symbol' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title'                => 'required',
        'customer_id'          => 'required',
        'estimate_number'      => 'required',
        'estimate_date'        => 'required',
        'currency'             => 'required',
        'discount_type'        => 'required',
        'unit'                 => 'required',
        'itemsArr'             => 'required|array',
        'itemsArr.*.item'      => 'required',
        'itemsArr.*.quantity'  => 'required',
        'itemsArr.*.rate'      => 'required',
    ];

    /**
     * @var array
     */
    public static $messages = [
        'customer_id.required'          => 'Customer field is required.',
        'estimate_expiry_date.required' => 'The Expiry Date field is required.',
        'currency.required'             => 'Currency field is required.',
        'itemsArr.required'             => 'Atleast one product is required.',
        'itemsArr.*.item.required'      => 'Product field is required.',
        'itemsArr.*.quantity.required'  => 'Quantity field is required',
        'itemsArr.*.rate.required'      => 'Rate field is required',
    ];

    /**
     * @return string
     */
    public static function generateUniqueEstimateId()
    {
        $estimateId = mb_strtoupper(Str::random(6));
        while (true) {
            $isExist = Estimate::whereEstimateNumber($estimateId)->exists();
            if ($isExist) {
                self::generateUniqueEstimateId();
            }
            break;
        }

        return $estimateId;
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getOwnerType()
    {
        return Estimate::class;
    }

    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }

    /**
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return MorphMany
     */
    public function salesItems()
    {
        return $this->morphMany(SalesItem::class, 'owner');
    }

    /**
     * @return MorphMany
     */
    public function salesTaxes()
    {
        return $this->morphMany(SalesTax::class, 'owner');
    }

    /**
     * @return HasMany
     */
    public function estimateAddresses()
    {
        return $this->hasMany(EstimateAddress::class);
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
        return self::DISCOUNT_TYPES[$discountTypeId];
    }
}
