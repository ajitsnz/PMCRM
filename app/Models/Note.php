<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Note
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property string $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $added_by
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereAddedBy($value)
 */
class Note extends Model
{
    public $table = 'notes';

    public $fillable = [
        'owner_id',
        'owner_type',
        'note',
        'added_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'owner_id'   => 'integer',
        'owner_type' => 'string',
        'note'       => 'string',
        'added_by'   => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
