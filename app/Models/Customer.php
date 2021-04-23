<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * Class Customer
 *
 * @package App\Models
 * @version April 3, 2020, 6:37 am UTC
 * @property int $id
 * @property string $company_name
 * @property string|null $vat_number
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $currency
 * @property string|null $country
 * @property string|null $default_language
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereCompanyName($value)
 * @method static Builder|Customer whereCountry($value)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereCurrency($value)
 * @method static Builder|Customer whereDefaultLanguage($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @method static Builder|Customer whereVatNumber($value)
 * @method static Builder|Customer whereWebsite($value)
 * @mixin Eloquent
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CustomerGroup[] $customerGroups
 * @property-read int|null $customer_groups_count
 */
class Customer extends Model
{
    const LANGUAGES = [
        'en' => 'English',
        'es' => 'Spanish',
        'fr' => 'French',
        'de' => 'German',
        'ru' => 'Russian',
        'pt' => 'Portuguese',
        'ar' => 'Arabic',
        'zh' => 'Chinese',
        'tr' => 'Turkish',
    ];

    const CURRENCIES = [
        '0' => 'INR',
        '1' => 'AUD',
        '2' => 'USD',
        '3' => 'EUR',
        '4' => 'JPY',
        '5' => 'GBP',
        '6' => 'CAD',
    ];

    const COUNTRIES = [
        '1' => 'India',
        '2' => 'Canada',
        '3' => 'USA',
        '4' => 'Germany',
        '5' => 'Russia',
        '6' => 'England',
        '7' => 'UAE',
        '8' => 'China',
        '9' => 'Turkey',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_name' => 'required|unique:customers,company_name',
        'zip'          => 'nullable|max:6',
        'website'      => 'nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
    ];

    public $table = 'customers';

    protected $fillable = [
        'company_name',
        'vat_number',
        'phone',
        'website',
        'currency',
        'country',
        'default_language',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'company_name' => 'string',
        'vat_number'   => 'string',
        'website'      => 'string',
        'country'      => 'string',
    ];

    /**
     * @return BelongsToMany
     */
    public function customerGroups()
    {
        return $this->belongsToMany(CustomerGroup::class, 'customer_to_customer_groups');
    }

    /**
     * @return MorphOne
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'owner');
    }

    /**
     * @return Model|MorphOne|object|null
     */
    public function billingAddress()
    {
        return $this->morphOne(Address::class, 'owner')
            ->where('type', '=', Address::ADDRESS_TYPES[1])->first();
    }

    /**
     * @return Model|MorphOne|object|null
     */
    public function shippingAddress()
    {
        return $this->morphOne(Address::class, 'owner')
            ->where('type', '=', Address::ADDRESS_TYPES[2])->first();
    }

    /**
     *
     * @return HasOne
     */
    public function contact()
    {
        return $this->hasOne(Contact::class, 'customer_id');
    }

    /**
     *
     * @return HasOne
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'customer_id');
    }

    /**
     *
     * @return HasOne
     */
    public function creditNote()
    {
        return $this->hasOne(CreditNote::class, 'customer_id');
    }

    /**
     *
     * @return HasOne
     */
    public function estimate()
    {
        return $this->hasOne(Estimate::class, 'customer_id');
    }

    /**
     *
     * @return HasOne
     */
    public function project()
    {
        return $this->hasOne(Project::class, 'customer_id');
    }

    /**
     *
     * @return HasOne
     */
    public function contract()
    {
        return $this->hasOne(Contract::class, 'customer_id');
    }

    /**
     *
     * @return HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'owner_id');
    }

    /**
     *
     * @return HasOne
     */
    public function proposal()
    {
        return $this->hasOne(Proposal::class, 'owner_id');
    }
}
