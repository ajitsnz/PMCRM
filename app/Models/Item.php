<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;

/**
 * Class Item
 *
 * @package App\Models
 * @version April 7, 2020, 4:28 am UTC
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property float $rate
 * @property int|null $tax_1_id
 * @property int|null $tax_2_id
 * @property int $item_group_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\TaxRate|null $firstTax
 * @property-read \App\Models\ItemGroup $group
 * @property-read \App\Models\TaxRate|null $secondTax
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereItemGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereTax1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereTax2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
    /**
     * @var string 
     */
    public $table = 'items';

    /**
     * @var array 
     */
    public $fillable = [
        'title',
        'description',
        'rate',
        'tax_1_id',
        'tax_2_id',
        'item_group_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'title'         => 'string',
        'description'   => 'string',
        'rate'          => 'double',
        'tax_1_id'      => 'integer',
        'tax_2_id'      => 'integer',
        'item_group_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title'         => 'required|unique:items,title',
        'rate'          => 'required',
        'description'   => 'nullable',
        'tax_1_id'      => 'nullable',
        'tax_2_id'      => 'nullable',
        'item_group_id' => 'required',
    ];

    /**
     * @return mixed
     */
    public function firstTax()
    {
        return $this->belongsTo(TaxRate::class, 'tax_1_id', 'id');
    }

    /**
     * @return mixed
     */
    public function secondTax()
    {
        return $this->belongsTo(TaxRate::class, 'tax_2_id', 'id');
    }

    /**
     * @return mixed
     */
    public function group()
    {
        return $this->belongsTo(ItemGroup::class, 'item_group_id');
    }
}
