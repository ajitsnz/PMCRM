<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\InvoiceTags
 *
 * @property int $id
 * @property int $taggable_id
 * @property string $taggable_type
 * @property int $tag_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags whereTaggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvoiceTags whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceTags extends Model
{
    public $table = 'taggables';

    public $fillable = [
        'owner_type',
        'owner_id',
        'tag_id',
    ];
}
