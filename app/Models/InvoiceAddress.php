<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\InvoiceAddress
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $type
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceAddress whereZipCode($value)
 * @mixin \Eloquent
 */
class InvoiceAddress extends Model
{
    /**
     * @var string
     */
    public $table = 'invoice_addresses';

    /**
     * @var array
     */
    public $fillable = [
        'street',
        'city',
        'state',
        'zip_code',
        'country',
        'type',
        'invoice_id',
    ];
}
