<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;

/**
 * Class ContractType
 *
 * @package App\Models
 * @version April 8, 2020, 4:20 am UTC
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContractType extends Model
{
    /**
     * @var string 
     */
    public $table = 'contract_types';

    /**
     * @var array 
     */
    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'name'        => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'        => 'required|unique:contract_types,name',
        'description' => 'nullable',
    ];

    /**
     *
     * @return mixed
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'contract_type_id');
    }
}
