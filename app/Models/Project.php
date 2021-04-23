<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $project_name
 * @property int $customer_id
 * @property int|null $calculate_progress_through_tasks
 * @property string|null $progress
 * @property int $billing_type
 * @property int $status
 * @property string|null $estimated_hours
 * @property Carbon $start_date
 * @property Carbon|null $deadline
 * @property string $description
 * @property int $send_email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProjectMember[] $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $projectContacts
 * @property-read int|null $project_contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereBillingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCalculateProgressThroughTasks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereEstimatedHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereSendEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Project extends Model implements \App\Models\Contracts\Taggable
{
    const BILLING_TYPES = [
        '0' => 'Fixed Rate',
        '1' => 'Project Hours',
        '2' => 'Task Hours',
    ];

    const STATUS_BADGE = [
        0 => 'badge-danger',
        1 => 'badge-primary',
        2 => 'badge-warning',
        3 => 'badge-info',
        4 => 'badge-success',
    ];

    const CARD_COLOR = [
        0 => 'danger',
        1 => 'primary',
        2 => 'warning',
        3 => 'info',
        4 => 'success',
    ];

    const STATUS = [
        '0' => 'Not Started',
        '1' => 'In Progress',
        '2' => 'On Hold',
        '3' => 'Cancelled',
        '4' => 'Finished',
    ];

    const STATUS_NOT_STARTED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_ON_HOLD = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_FINISHED = 4;

    public $table = 'projects';

    public $fillable = [
        'project_name',
        'calculate_progress_through_tasks',
        'progress',
        'billing_type',
        'status',
        'estimated_hours',
        'start_date',
        'deadline',
        'description',
        'send_email',
        'customer_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                               => 'integer',
        'project_name'                     => 'string',
        'calculate_progress_through_tasks' => 'integer',
        'progress'                         => 'string',
        'billing_type'                     => 'integer',
        'status'                           => 'integer',
        'estimated_hours'                  => 'string',
        'start_date'                       => 'date',
        'deadline'                         => 'date',
        'description'                      => 'string',
        'customer_id'                      => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'project_name' => 'required|unique:projects,project_name',
        'customer_id'  => 'required',
        'members'      => 'required',
        'billing_type' => 'required',
        'status'       => 'required',
        'start_date'   => 'required',
        'deadline'     => 'required',

    ];

    /**
     * @var array
     */
    public static $messages = [
        'customer_id.required' => 'Customer field is required.',
    ];

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
    public function members()
    {
        return $this->hasMany(ProjectMember::class, 'owner_id');
    }

    /**
     *
     * @return belongsToMany
     */
    public function projectContacts()
    {
        return $this->belongsToMany(Contact::class, 'project_contacts',
            'project_id', 'contact_id')->withPivot(['contact_id']);
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
     * @return mixed|string
     */
    public function getOwnerType()
    {
        return Project::class;
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public static function getBillingTypeText($id)
    {
        return self::BILLING_TYPES[$id];
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public static function getStatusText($id)
    {
        return self::STATUS[$id];
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return $this->attributes['description'] = htmlspecialchars_decode($value);
    }
}
