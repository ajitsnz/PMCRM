<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Str;

/**
 * App\Models\Proposal
 *
 * @property int $id
 * @property string $proposal_number
 * @property string $title
 * @property int $related
 * @property Carbon $date
 * @property Carbon|null $open_till
 * @property int $currency
 * @property int|null $discount_type
 * @property int $status
 * @property int|null $assigned_user_id
 * @property string|null $phone
 * @property float|null $discount
 * @property int $unit
 * @property float|null $sub_total
 * @property float $adjustment
 * @property float|null $total_amount
 * @property int|null $payment_status
 * @property int|null $discount_symbol
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|ProposalAddress[] $proposalAddresses
 * @property-read int|null $proposal_addresses_count
 * @property-read Collection|SalesItem[] $salesItems
 * @property-read int|null $sales_items_count
 * @property-read Collection|SalesTax[] $salesTaxes
 * @property-read int|null $sales_taxes_count
 * @property-read Collection|Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read User|null $user
 * @method static Builder|Proposal newModelQuery()
 * @method static Builder|Proposal newQuery()
 * @method static Builder|Proposal query()
 * @method static Builder|Proposal whereAdjustment($value)
 * @method static Builder|Proposal whereAssignedUserId($value)
 * @method static Builder|Proposal whereCreatedAt($value)
 * @method static Builder|Proposal whereCurrency($value)
 * @method static Builder|Proposal whereDate($value)
 * @method static Builder|Proposal whereDiscount($value)
 * @method static Builder|Proposal whereDiscountType($value)
 * @method static Builder|Proposal whereId($value)
 * @method static Builder|Invoice whereProposalNumber($value)
 * @method static Builder|Proposal whereOpenTill($value)
 * @method static Builder|Proposal wherePaymentStatus($value)
 * @method static Builder|Proposal wherePhone($value)
 * @method static Builder|Proposal whereRelated($value)
 * @method static Builder|Proposal whereStatus($value)
 * @method static Builder|Proposal whereSubTotal($value)
 * @method static Builder|Proposal whereTitle($value)
 * @method static Builder|Proposal whereTotalAmount($value)
 * @method static Builder|Proposal whereUnit($value)
 * @method static Builder|Proposal whereUpdatedAt($value)
 * @method static Builder|Proposal whereOwnerType($value)
 * @method static Builder|Proposal whereOwnerId($value)
 * @mixin Model
 * @property int|null $related_to
 * @property int|null $owner_id
 * @property string|null $owner_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proposal whereRelatedTo($value)
 */
class Proposal extends Model implements \App\Models\Contracts\Taggable
{
    const UNIT_MEASURES = [
        1 => 'Quantity',
        2 => 'Hours',
        3 => 'Qty/Hours',
    ];

    const STATUS = [
        1 => 'Drafted',
        2 => 'Open',
        3 => 'Revised',
        4 => 'Declined',
        5 => 'Accepted',
    ];

    const STATUS_COLOR = [
        1 => 'warning',
        2 => 'danger',
        3 => 'primary',
        4 => 'info',
        5 => 'success',
    ];

    const STATUS_DRAFT = 1;
    const STATUS_OPEN = 2;
    const STATUS_REVISED = 3;
    const STATUS_DECLINED = 4;
    const STATUS_ACCEPTED = 5;

    const CLIENT_STATUS = [
        2 => 'Open',
        3 => 'Revised',
        4 => 'Declined',
        5 => 'Accepted',
    ];

    const RELATED_TO = [
        1 => Lead::class,
        2 => Customer::class,
    ];

    const RELATED_TO_array = [
        1 => 'Lead',
        2 => 'Customer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'proposal_number'     => 'required|unique:proposals,proposal_number',
        'title'               => 'required',
        'related_to'          => 'required',
        'date'                => 'required',
        'currency'            => 'required',
        'discount_type'       => 'required',
        'unit'                => 'required',
        'phone'               => 'nullable|numeric',
        'status'              => 'required',
        'assigned_user_id'    => 'required',
        'owner_id'            => 'required',
        'itemsArr'            => 'required|array',
        'itemsArr.*.item'     => 'required',
        'itemsArr.*.quantity' => 'required',
        'itemsArr.*.rate'     => 'required',
        'zip_code'            => 'nullable|min:6',
    ];

    /**
     * @var array
     */
    public static $messages = [
        'related_to.required'          => 'Related field is required.',
        'assigned_user_id.required'    => 'Member field is required',
        'itemsArr.required'            => 'Atleast one product is required.',
        'itemsArr.*.item.required'     => 'Product field is required.',
        'itemsArr.*.quantity.required' => 'Quantity field is required',
        'itemsArr.*.rate.required'     => 'Rate field is required',
    ];

    /**
     * @var string
     */
    public $table = 'proposals';

    /**
     * @var array
     */
    public $fillable = [
        'proposal_number',
        'title',
        'related_to',
        'date',
        'open_till',
        'currency',
        'discount_type',
        'status',
        'assigned_user_id',
        'phone',
        'unit',
        'total_amount',
        'sub_total',
        'discount',
        'adjustment',
        'payment_status',
        'owner_id',
        'owner_type',
        'discount_symbol',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'              => 'integer',
        'proposal_number' => 'string',
        'title'           => 'string',
        'related_to'      => 'integer',
        'date'            => 'datetime',
        'open_till'       => 'datetime',
        'currency'        => 'integer',
        'discount_type'   => 'integer',
        'status'          => 'integer',
        'user_id'         => 'integer',
        'phone'           => 'string',
        'admin_text'      => 'string',
        'total_amount'    => 'double',
        'sub_total'       => 'double',
        'discount'        => 'double',
        'adjustment'      => 'double',
        'owner_id'        => 'integer',
        'owner_type'      => 'string',
        'discount_symbol' => 'integer',
    ];

    /**
     * @return string
     */
    public static function generateUniqueProposalId()
    {
        $proposalId = mb_strtoupper(Str::random(6));

        while (true) {
            $isExist = Proposal::whereProposalNumber($proposalId)->exists();
            if ($isExist) {
                self::generateUniqueProposalId();
            }
            break;
        }

        return $proposalId;
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
    public function proposalAddresses()
    {
        return $this->hasMany(ProposalAddress::class);
    }

    /**
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
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
        return Proposal::class;
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * @return HasMany
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

    /**
     * @param  int  $relatedId
     *
     * @return mixed
     */
    public function getRelatedText($relatedId)
    {
        return self::RELATED_TO_array[$relatedId];
    }

    /**
     * @param  int  $statusId
     *
     * @return mixed
     */
    public function getStatusText($statusId)
    {
        return self::STATUS[$statusId];
    }

    /**
     *
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'owner_id');
    }

    /**
     *
     * @return mixed
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'owner_id');
    }
}
