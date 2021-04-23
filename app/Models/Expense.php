<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * Class Expense
 *
 * @package App\Models
 * @version April 20, 2020, 5:16 am UTC
 * @property string name
 * @property string|null $note
 * @property int expense_category_id
 * @property Carbon expense_date
 * @property double amount
 * @property int|null $customer_id
 * @property int currency
 * @property int|null $tax_1_id
 * @property int|null $tax_2_id
 * @property int|null $payment_mode_id
 * @property string|null $reference
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense query()
 * @mixin \Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereExpenseCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereExpenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense wherePaymentModeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereTax1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereTax2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereUpdatedAt($value)
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\ExpenseCategory $expenseCategory
 * @property-read Collection|\App\Models\PaymentMode[] $paymentMode
 * @property-read int|null $payment_mode_count
 * @property-read \App\Models\TaxRate|null $taxRate1
 * @property-read \App\Models\TaxRate|null $taxRate2
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\TaxRate|null $tax1Rate
 * @property-read \App\Models\TaxRate|null $tax2Rate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereTax1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereTax2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereTaxApplied($value)
 * @property bool|null $tax_applied
 * @property int|null $tax_rate
 * @property int|null $billable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereTaxRate($value)
 * @property-read bool|string $expense_attachment
 */
class Expense extends Model implements HasMedia
{
    use HasMediaTrait;

    public const EXPENSE_RECEIPT = 'expense';

    const CURRENCIES = [
        '0' => 'Indian Rupee',
        '1' => 'Spanish Dollar',
        '2' => 'USA Dollar',
        '3' => 'Canada Dollar',
        '4' => 'Germany Dollar',
        '5' => 'China Dollar',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'                => 'required|unique:expenses,name',
        'expense_category_id' => 'required',
        'expense_date'        => 'required',
        'amount'              => 'required',
        'currency'            => 'required',
        'receipt_attachment'  => 'nullable|mimes:jpeg,png,pdf,docx,doc',
    ];

    public $table = 'expenses';

    public $fillable = [
        'name',
        'note',
        'expense_category_id',
        'expense_date',
        'amount',
        'customer_id',
        'currency',
        'tax_applied',
        'tax_1_id',
        'tax_2_id',
        'tax_rate',
        'payment_mode_id',
        'reference',
        'billable',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                  => 'integer',
        'name'                => 'string',
        'note'                => 'string',
        'expense_category_id' => 'integer',
        'expense_date'        => 'datetime',
        'amount'              => 'double',
        'customer_id'         => 'integer',
        'currency'            => 'integer',
        'tax_applied'         => 'boolean',
        'tax_1_id'            => 'integer',
        'tax_2_id'            => 'integer',
        'tax_rate'            => 'double',
        'payment_mode_id'     => 'integer',
        'reference'           => 'string',
        'billable'            => 'boolean',
    ];

    /**
     * @var array
     */
    protected $appends = ['expense_attachment'];

    /**
     * @return bool|string
     */
    public function getExpenseAttachmentAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(Expense::EXPENSE_RECEIPT)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return false;
    }

    /**
     * @return BelongsTo
     */
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return belongsTo
     */
    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode_id');
    }

    /**
     * @return belongsTo
     */
    public function tax1Rate()
    {
        return $this->belongsTo(TaxRate::class, 'tax_1_id');
    }

    /**
     * @return belongsTo
     */
    public function tax2Rate()
    {
        return $this->belongsTo(TaxRate::class, 'tax_2_id');
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'owner_id');
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
