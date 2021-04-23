<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class LeadSource
 *
 * @package App\Models
 * @version April 6, 2020, 5:43 am UTC
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadSource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadSource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadSource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadSource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadSource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadSource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LeadSource whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadSource extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:lead_sources,name',
    ];

    public $table = 'lead_sources';

    public $fillable = [
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'   => 'integer',
        'name' => 'string',
    ];

    /**
     * @return HasOne
     */
    public function usedLeadSource()
    {
        return $this->hasOne(Lead::class, 'source_id');
    }
}
