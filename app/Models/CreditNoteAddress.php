<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CreditNoteAddress
 *
 * @property int $id
 * @property int $credit_note_id
 * @property int $type
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CreditNoteAddress newModelQuery()
 * @method static Builder|CreditNoteAddress newQuery()
 * @method static Builder|CreditNoteAddress query()
 * @method static Builder|CreditNoteAddress whereCity($value)
 * @method static Builder|CreditNoteAddress whereCountry($value)
 * @method static Builder|CreditNoteAddress whereCreatedAt($value)
 * @method static Builder|CreditNoteAddress whereCreditNoteId($value)
 * @method static Builder|CreditNoteAddress whereId($value)
 * @method static Builder|CreditNoteAddress whereState($value)
 * @method static Builder|CreditNoteAddress whereStreet($value)
 * @method static Builder|CreditNoteAddress whereType($value)
 * @method static Builder|CreditNoteAddress whereUpdatedAt($value)
 * @method static Builder|CreditNoteAddress whereZipCode($value)
 * @mixin Eloquent
 */
class CreditNoteAddress extends Model
{
    /**
     * @var string
     */
    public $table = 'credit_note_addresses';

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
        'credit_note_id',
    ];
}
