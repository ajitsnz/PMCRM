<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProposalAddress
 *
 * @property int $id
 * @property int $proposal_id
 * @property int $type
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereProposalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalAddress whereZipCode($value)
 * @mixin \Eloquent
 */
class ProposalAddress extends Model
{
    /**
     * @var string
     */
    public $table = 'proposal_addresses';

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
        'proposal_id',
    ];
}
