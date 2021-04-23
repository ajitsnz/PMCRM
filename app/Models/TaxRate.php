<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;

/**
 * Class TaxRate
 *
 * @package App\Models
 * @version April 6, 2020, 6:48 am UTC
 * @property int $id
 * @property string $name
 * @property float $tax_rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaxRate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxRate extends Model
{
    /**
     * @var string 
     */
    public $table = 'tax_rates';

    /**
     * @var array 
     */
    public $fillable = [
        'name',
        'tax_rate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'       => 'integer',
        'name'     => 'string',
        'tax_rate' => 'double',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'     => 'required|unique:tax_rates,name',
        'tax_rate' => 'required|max:5',
    ];
}
