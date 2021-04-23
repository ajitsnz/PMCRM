<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Announcement
 *
 * @package App\Models
 * @version April 6, 2020, 6:50 am UTC
 * @property int $id
 * @property string subject
 * @property Carbon $date
 * @property string message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool|null $show_to_clients
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereShowToClients($value)
 * @property bool $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereStatus($value)
 */
class Announcement extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject' => 'required|unique:announcements,subject',
    ];

    public $table = 'announcements';

    public $fillable = [
        'subject',
        'date',
        'message',
        'show_to_clients',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'              => 'integer',
        'subject'         => 'string',
        'date'            => 'datetime',
        'message'         => 'string',
        'show_to_clients' => 'boolean',
        'status'          => 'boolean',
    ];

    const PENDING = 0;
    const COMPLETED = 1;

    const STATUS_ARRAY = [
        self::PENDING   => 'Pending',
        self::COMPLETED => 'Completed',
    ];
}
