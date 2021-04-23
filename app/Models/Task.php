<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * Class Task
 *
 * @package App\Models
 * @version April 13, 2020, 10:21 am UTC
 * @property int $id
 * @property int|null $public
 * @property int|null $billable
 * @property string $subject
 * @property int $status
 * @property string|null $hourly_rate
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $priority
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereHourlyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $due_date
 * @property int|null $related_to
 * @property string|null $owner_type
 * @property int|null $owner_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereRelatedTo($value)
 * @property int|null $member_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereMemberId($value)
 */
class Task extends Model
{
    const NOT_STARTED_STATUS = 1;

    const STATUS = [
        1 => 'Not Started',
        2 => 'In Progress',
        3 => 'Testing',
        4 => 'Awaiting Feedback',
        5 => 'Completed',
    ];

    const PRIORITY = [
        1 => 'Low',
        2 => 'Medium',
        3 => 'High',
        4 => 'Urgent',
    ];

    const RELATED_TO = [
        1 => Invoice::class,
        2 => Customer::class,
        3 => Ticket::class,
        4 => Project::class,
        5 => Proposal::class,
        6 => Estimate::class,
        7 => Lead::class,
        8 => Contract::class,
    ];

    const RELATED_TO_array = [
        1 => 'Invoice',
        2 => 'Customer',
        3 => 'Ticket',
        4 => 'Project',
        5 => 'Proposal',
        6 => 'Estimate',
        7 => 'Lead',
        8 => 'Contract',
    ];

    public $table = 'tasks';

    public $fillable = [
        'public',
        'billable',
        'subject',
        'status',
        'hourly_rate',
        'start_date',
        'due_date',
        'priority',
        'description',
        'related_to',
        'owner_type',
        'owner_id',
        'member_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'subject' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject'    => 'required|unique:tasks,subject',
        'status'     => 'required',
    ];

    /**
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'owner_id');
    }

    /**
     * @param string $ownerType
     * @param string $ownerFieldName
     *
     * @return mixed
     */
    public function getRelatedTo($ownerType, $ownerFieldName)
    {
        return $this->belongsTo($ownerType, 'owner_id')->value($ownerFieldName);
    }
}
