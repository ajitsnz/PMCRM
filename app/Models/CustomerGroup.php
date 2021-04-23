<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CustomerGroup
 *
 * @property int $id
 * @property string $name
 * @property mixed|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CustomerGroup newModelQuery()
 * @method static Builder|CustomerGroup newQuery()
 * @method static Builder|CustomerGroup query()
 * @method static Builder|CustomerGroup whereCreatedAt($value)
 * @method static Builder|CustomerGroup whereDescription($value)
 * @method static Builder|CustomerGroup whereId($value)
 * @method static Builder|CustomerGroup whereName($value)
 * @method static Builder|CustomerGroup whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CustomerGroup extends Model
{
    /**
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:customer_groups,name',
    ];

    /**
     * @var string
     */
    public $table = 'customer_groups';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'description',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'name'        => 'string',
        'description' => 'text',
    ];

    /**
     * @param $value
     *
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * @return mixed
     */
    public function customers()
    {
        return $this->hasMany(CustomerToCustomerGroup::class, 'customer_group_id');
    }

}
