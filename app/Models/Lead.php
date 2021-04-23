<?php

namespace App\Models;

use App\Models\Contracts\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * Class Lead
 *
 * @package App\Models
 * @version April 20, 2020, 12:43 pm UTC
 * @property int $id
 * @property int $status_id
 * @property int $source_id
 * @property int|null $assign_to
 * @property string $name
 * @property string|null $position
 * @property string|null $email
 * @property int|null $estimate_budget
 * @property string|null $website
 * @property string|null $phone
 * @property string|null $company
 * @property string|null $description
 * @property int|null $default_language
 * @property int|null $public
 * @property int|null $contacted_today
 * @property string|null $date_contacted
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Address $address
 * @property-read \App\Models\LeadSource $leadSource
 * @property-read \App\Models\LeadStatus $leadStatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereAssignTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereContactedToday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereDateContacted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereDefaultLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereWebsite($value)
 *  * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereEstimateBudget($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User|null $assignedTo
 * @property string $company_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Note[] $notes
 * @property-read int|null $notes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereCompanyName($value)
 * @property int $lead_convert_customer
 * @property string|null $lead_convert_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereLeadConvertCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereLeadConvertDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereCountry($value)
 */
class Lead extends Model implements Taggable
{
    public $table = 'leads';

    public $fillable = [
        'name',
        'status_id',
        'source_id',
        'company_name',
        'estimate_budget',
        'assign_to',
        'position',
        'website',
        'phone',
        'description',
        'default_language',
        'public',
        'contacted_today',
        'date_contacted',
        'lead_convert_date',
        'country',
    ];

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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'         => 'required|unique:leads,name',
        'status_id'    => 'required',
        'source_id'    => 'required',
        'company_name' => 'required',
        'website'      => 'nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
    ];

    /**
     * @return BelongsTo
     */
    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'status_id');
    }

    /**
     * @return BelongsTo
     */
    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'source_id');
    }

    /**
     * @return MorphOne
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'owner');
    }

    /**
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assign_to');
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
        return Lead::class;
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
