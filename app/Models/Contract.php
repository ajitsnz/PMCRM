<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Contract
 *
 * @property int $id
 * @property string $subject
 * @property string|null $description
 * @property string|null $start_date
 * @property Carbon|null $end_date
 * @property float|null $contract_value
 * @property int $customer_id
 * @property int $contract_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\ContractType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereContractTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereContractValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contract extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject'          => 'required|unique:contracts,subject',
        'customer_id'      => 'required',
        'contract_type_id' => 'required',
    ];

    public $table = 'contracts';

    public $fillable = [
        'customer_id',
        'contract_type_id',
        'start_date',
        'end_date',
        'subject',
        'contract_value',
        'description',
    ];

    protected $dates = ['created_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'               => 'integer',
        'customer_id'      => 'integer',
        'goal_type_id'     => 'integer',
        'contract_type_id' => 'integer',
        'start_date'       => 'datetime',
        'end_date'         => 'datetime',
        'subject'          => 'string',
        'description'      => 'string',
        'contract_value'   => 'double',
    ];

    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }
}
