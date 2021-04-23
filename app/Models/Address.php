<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Address
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address query()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $owner_id
 * @property string|null $owner_type
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $country
 * @property string|null $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereZip($value)
 */
class Address extends Model
{
    const ADDRESS_TYPES = [
        '0' => 'Billing/Shipping',
        '1' => 'Billing Address',
        '2' => 'Shipping Address',
    ];

    public $table = 'addresses';

    protected $fillable = [
        'owner_id',
        'owner_type',
        'street',
        'city',
        'state',
        'zip',
        'country',
        'type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'owner_id'   => 'integer',
        'owner_type' => 'string',
        'street'     => 'string',
        'city'       => 'string',
        'state'      => 'string',
        'zip'        => 'string',
        'country'    => 'string',
    ];

    /**
     * @param  array  $input
     *
     * @return array
     */
    public static function prepareAddressArray($input)
    {
        $address = [
            'street'  => $input['street'],
            'city'    => $input['address_city'],
            'zip'     => $input['address_zip'],
            'state'   => $input['state'],
            'country' => $input['address_country'],
        ];

        return $address;
    }

    /**
     * @param  array  $input
     *
     * @return array
     */
    public static function prepareInputForAddress($input)
    {
        $items = [];
        foreach ($input as $key => $data) {
            foreach ($data as $index => $value) {
                $items[$index][$key] = $value;
            }
        }

        return $items;
    }

    /**
     * @param  array  $input
     *
     * @return bool
     */
    public static function containsOnlyNull($input)
    {
        return empty(array_filter($input, function ($key) {
            return $key !== null;
        }));
    }

    /**
     *
     * @return MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
