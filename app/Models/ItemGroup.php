<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;

/**
 * Class ItemGroup
 *
 * @package App\Models
 * @version April 6, 2020, 5:56 am UTC
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ItemGroup extends Model
{
    /**
     * @var string 
     */
    public $table = 'item_groups';

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
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:item_groups,name',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'item_group_id');
    }
}
