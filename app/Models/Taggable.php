<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Taggable
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property int $tag_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $taggable_id
 * @property string $taggable_type
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $owner
 * @property-read \App\Models\Tag $tag
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereTaggableType($value)
 */
class Taggable extends Model
{
    public $table = 'taggables';

    public $fillable = [
        'owner_id',
        'owner_type',
        'tag_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'owner_id'   => 'integer',
        'owner_type' => 'string',
        'tag_id'     => 'integer',
    ];

    /**
     * @return MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
