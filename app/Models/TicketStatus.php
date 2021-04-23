<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class TicketStatus
 *
 * @package App\Models
 * @version April 4, 2020, 3:50 am UTC
 * @property string $name
 * @property string pick_color
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus wherePickColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $is_default
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereName($value)
 */
class TicketStatus extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'       => 'required|unique:ticket_statuses,name',
    ];

    public $table = 'ticket_statuses';

    public $fillable = [
        'name',
        'pick_color',
        'is_default',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'name'       => 'string',
        'pick_color' => 'string',
        'is_default' => 'integer',
    ];

    /**
     * @return HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_status_id');
    }
}
