<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property int $group
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model implements HasMedia
{
    use HasMediaTrait;

    public const PATH = 'settings';
    public const FAVICON = 'settings/favicon';
    const GROUP_GENERAL = 1;
    const COMPANY_INFORMATION = 2;
    const NOTE = 3;

    const GROUP_ARRAY = [
        'general'             => self::GROUP_GENERAL,
        'company_information' => self::COMPANY_INFORMATION,
        'note'                => self::NOTE,
    ];

    const CURRENCIES = [
        'eur' => 'Euro (EUR)',
        'aud' => 'Australia Dollar (AUD)',
        'inr' => 'India Rupee (INR)',
        'usd' => 'USA Dollar (USD)',
        'jpy' => 'Japanese Yen (JPY)',
        'gbp' => 'British Pound (GBP)',
        'cad' => 'Canadian Dollar (CAD)',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'group' => 'required|integer',
    ];

    public $table = 'settings';

    public $fillable = [
        'key',
        'value',
        'company_name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'integer',
        'key'   => 'string',
        'value' => 'string',
    ];

}
