<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CustomerToCustomerGroup
 *
 * @property int $id
 * @property int $customer_id
 * @property int $customer_group_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup whereCustomerGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerToCustomerGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerToCustomerGroup extends Model
{
    /**
     * @var string
     */
    public $table = 'customer_to_customer_groups';

    /**
     * @var array
     */
    public $fillable = [
        'customer_id',
        'customer_group_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
