<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\SalesItem
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property string $item
 * @property string|null $description
 * @property int $quantity
 * @property float $rate
 * @property float $total
 * @property string $tax_ids
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereTaxIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaxRate[] $taxes
 * @property-read int|null $taxes_count
 */
class SalesItem extends Model
{
    /**
     * @var string
     */
    public $table = 'sales_items';

    /**
     * @var array
     */
    public $fillable = [
        'owner_id',
        'owner_type',
        'item',
        'description',
        'quantity',
        'rate',
        'total',
    ];

    protected $casts = [
        'owner_id'    => 'integer',
        'owner_type'  => 'string',
        'item'        => 'string',
        'description' => 'string',
        'quantity'    => 'integer',
        'rate'        => 'double',
        'total'       => 'double',
    ];

    /**
     * @return BelongsToMany
     */
    public function taxes()
    {
        return $this->belongsToMany(
            TaxRate::class,
            'sales_item_taxes',
            'sales_item_id',
            'tax_id'
        )->withTimestamps();
    }
}
