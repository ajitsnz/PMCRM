<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 * @property string $password
 * @property string $image
 * @property string|null $default_language
 * @property boolean $is_enable
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *     $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $facebook
 * @property string|null $linkedin
 * @property string|null $skype
 * @property bool|null $staff_member
 * @property bool|null $send_welcome_email
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDefaultLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereHourlyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSendWelcomeEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStaffMember($value)
 * @property int|null $owner_id
 * @property string|null $owner_type
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerType($value)
 * @property-read \App\Models\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User user()
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Notifiable, HasRoles, HasMediaTrait;

    public const COLLECTION_PROFILE_PICTURES = 'profile';

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

    protected $dates = ['created_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'image',
        'facebook',
        'linkedin',
        'skype',
        'is_enable',
        'staff_member',
        'send_welcome_email',
        'default_language',
        'owner_id',
        'owner_type',
    ];

    const STATUS_ALL = 2;
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'Select Status',
        self::ACTIVE     => 'Active',
        self::INACTIVE   => 'Deactive',
    ];

    /**
     * @return MorphTo
     */
    public function owner()
    {
        return $this->morphTo('owner');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $appends = ['full_name', 'image_url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                 => 'integer',
        'first_name'         => 'string',
        'last_name'          => 'string',
        'email_verified_at'  => 'datetime',
        'created_at'         => 'datetime',
        'image'              => 'string',
        'facebook'           => 'string',
        'linkedin'           => 'string',
        'skype'              => 'string',
        'is_enable'          => 'boolean',
        'staff_member'       => 'boolean',
        'send_welcome_email' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name'            => 'required',
        'phone'                 => 'required',
        'email'                 => 'required|email|unique:users,email',
        'password'              => 'required|same:password_confirmation|min:6',
        'password_confirmation' => 'required',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $editRules = [
        'first_name' => 'required',
        'last_name'  => 'nullable',
        'phone'      => 'required',
        'email'      => 'required',
    ];

    /**
     * @var array
     */
    public static $messages = [
        'email.regex'   => 'Please enter valid email.',
        'password.same' => 'The password and confirm password must match',
    ];

    /**
     *
     * @return HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id');
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    /**
     * @return mixed
     */
    public function getImageUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(User::COLLECTION_PROFILE_PICTURES)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return getUserImageInitial($this->id, $this->full_name);
    }

    /**
     * @return string
     */
    public function getRoleNamesAttribute()
    {
        return implode(',', $this->roles->pluck('display_name')->toArray());
    }

    /**
     * @return BelongsToMany
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_departments', 'user_id', 'department_id');
    }

    /**
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeUser($query)
    {
        return $query->where('owner_type', '!=', Contact::class)->orWhereNull('owner_type');
    }

    /**
     * @return HasOne
     */
    public function contact()
    {
        return $this->hasOne(Contact::class, 'user_id');
    }

    /**
     *
     * @return HasOne
     */
    public function proposal()
    {
        return $this->hasOne(Proposal::class, 'assigned_user_id');
    }

    /**
     *
     * @return BelongsToMany
     */
    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'goal_members');
    }

    /**
     * @return mixed
     */
    public function projects()
    {
        return $this->hasMany(ProjectMember::class, 'user_id');
    }
}
