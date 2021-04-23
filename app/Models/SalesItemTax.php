<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\SalesTaxes
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property int $tax_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SalesItemTax newModelQuery()
 * @method static Builder|SalesItemTax newQuery()
 * @method static Builder|SalesItemTax query()
 * @method static Builder|SalesItemTax whereCreatedAt($value)
 * @method static Builder|SalesItemTax whereId($value)
 * @method static Builder|SalesItemTax whereOwnerId($value)
 * @method static Builder|SalesItemTax whereOwnerType($value)
 * @method static Builder|SalesItemTax whereTaxId($value)
 * @method static Builder|SalesItemTax whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $sales_item_id
 * @property-read \App\Models\TaxRate $salesTaxes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesItemTax whereSalesItemId($value)
 */
class SalesItemTax extends Model
{
    /**
     * @var string
     */
    public $table = 'sales_item_taxes';

    /**
     * @var array
     */
    public $fillable = [
        'owner_id',
        'owner_type',
        'tax_id',
    ];

    /**
     * @return BelongsTo
     */
    public function salesTaxes()
    {
        return $this->belongsTo(TaxRate::class, 'tax_id');
    }
}
