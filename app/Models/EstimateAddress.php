<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EstimateAddress
 *
 * @property int $id
 * @property int $estimate_id
 * @property int $type
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereEstimateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstimateAddress whereZipCode($value)
 * @mixin \Eloquent
 */
class EstimateAddress extends Model
{
    /**
     * @var string
     */
    public $table = 'estimate_addresses';

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
        'estimate_id',
    ];
}
