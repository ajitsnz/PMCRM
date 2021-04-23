<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class LeadStatus
 *
 * @package App\Models
 * @version April 6, 2020, 4:03 am UTC
 * @property int $id
 * @property string $name
 * @property string|null $color
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus query()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadStatus whereUpdatedAt($value)
 */
class LeadStatus extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'  => 'required|unique:lead_statuses,name',
        'order' => 'required',
    ];

    public $table = 'lead_statuses';

    public $fillable = [
        'name',
        'color',
        'order',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'integer',
        'name'  => 'string',
        'color' => 'string',
        'order' => 'integer',
    ];

    /**
     * @return HasMany
     */
    public function leads()
    {
        return $this->hasMany(Lead::class, 'status_id');
    }
}
