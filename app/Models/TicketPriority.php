<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class TicketPriority
 *
 * @package App\Models
 * @version April 3, 2020, 8:00 am UTC
 * @property string $name
 * @property bool $status
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketPriority whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketPriority extends Model
{
    const STATUS_ALL = 2;
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'Select Status',
        self::ACTIVE     => 'Active',
        self::INACTIVE   => 'Deactive',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:ticket_priorities,name',
    ];

    public $table = 'ticket_priorities';

    public $fillable = [
        'name',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'     => 'integer',
        'name'   => 'string',
        'status' => 'boolean',
    ];

    /**
     *
     * @return HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id');
    }
}
