<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Reminder
 *
 * @package App\Models
 * @version April 15, 2020, 9:24 am UTC
 * @property string|\Carbon\Carbon notified_date
 * @property int reminder_to
 * @property string description
 * @property bool|null $is_notified
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereIsNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereNotifiedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereReminderTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $owner_id
 * @property string $owner_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereOwnerType($value)
 * @property int $added_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder whereAddedBy($value)
 * @property-read \App\Models\Contact $contact
 * @property bool $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereStatus($value)

 */
class Reminder extends Model
{
    const REMINDER_MODULES = [
        1 => Ticket::class,
        2 => Task::class,
        3 => Invoice::class,
        4 => Expense::class,
        5 => Customer::class,
        6 => Lead::class,
        7 => Proposal::class,
    ];

    const IS_NOTIFIED = [
        1 => 'Active',
        0 => 'Deactive',
    ];

    const PENDING = 0;
    const COMPLETED = 1;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'notified_date' => 'required',
        'reminder_to'   => 'required',
        'description'   => 'required',
    ];

    public $table = 'reminders';

    public $fillable = [
        'owner_id',
        'owner_type',
        'notified_date',
        'reminder_to',
        'description',
        'is_notified',
        'added_by',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'owner_id'      => 'integer',
        'owner_type'    => 'string',
        'reminder_to'   => 'integer',
        'description'   => 'string',
        'is_notified'   => 'boolean',
        'status'   => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'reminder_to');
    }

    /**
     * @return BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'reminder_to');
    }
}
