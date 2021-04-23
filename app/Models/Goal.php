<?php

namespace App\Models;

use App\Repositories\GoalRepository;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;


/**
 * App\Models\Goal
 *
 * @property int $id
 * @property string $subject
 * @property string|null $description
 * @property int $goal_type
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string|null $achievement
 * @property bool|null $is_notify
 * @property bool|null $is_not_notify
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $goalMembers
 * @property-read int|null $goal_members_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereAchievement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereGoalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereIsNotNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereIsNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goal whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $goal_progress_count
 */
class Goal extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject'     => 'required|unique:goals,subject',
        'users'       => 'required',
        'achievement' => 'required|numeric|min:1',
        'start_date'  => 'required',
        'end_date'    => 'required',
    ];

    /**
     * @var array
     */
    public static $messages = [
        'subject.required'     => 'Subject field is required.',
        'users.required'       => 'Staff member field is required.',
        'achievement.required' => 'Achievement field is required.',
        'start_date.required'  => 'Start date field is required.',
        'end_date.required'    => 'End date field is required.',
    ];

    public $table = 'goals';

    protected $appends = ['goal_progress_count'];

    public $fillable = [
        'start_date',
        'end_date',
        'subject',
        'achievement',
        'description',
        'goal_type',
        'is_notify',
        'is_not_notify',
    ];

    protected $dates = ['created_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'start_date'    => 'datetime',
        'end_date'      => 'datetime',
        'subject'       => 'string',
        'description'   => 'string',
        'goal_type'     => 'integer',
        'is_notify'     => 'boolean',
        'is_not_notify' => 'boolean',
        'achievement'   => 'double',
    ];

    const INVOICE_AMOUNT = 2;
    const CONVERT_X_LEAD = 3;
    const INCREASE_CUSTOMER_NUMBER = 4;


    const GOAL_TYPE = [
        self::INVOICE_AMOUNT           => 'Invoice Amount',
        self::CONVERT_X_LEAD           => 'Convert X Lead',
        self::INCREASE_CUSTOMER_NUMBER => 'Increase Customer Number',
    ];

    /**
     *
     * @return belongsToMany
     */
    public function goalMembers()
    {
        return $this->belongsToMany(User::class, 'goal_members');
    }

    /**
     * @return mixed
     */
    public function getGoalProgressCountAttribute()
    {
        $data['goal_ype'] = $this->goal_type;
        $data['start_date'] = Carbon::parse($this->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($this->end_date)->format('Y-m-d');
        $data['achievement'] = $this->achievement;

        /** @var GoalRepository $goalRepo */
        $goalRepo = app(GoalRepository::class);
        $goalProgress = $goalRepo->countGoalProgress($data);

        return $goalProgress;
    }
}
