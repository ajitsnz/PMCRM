<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class SalesTax
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property string $tax
 * @property float $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesTax whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SalesTax extends Model
{
    protected $table = 'sales_taxes';

    protected $fillable = [
        'owner_id',
        'owner_type',
        'tax',
        'amount',
    ];

    protected $casts = [
        'owner_id'   => 'integer',
        'owner_type' => 'string',
        'tax'        => 'string',
        'amount'     => 'double',
    ];
}
