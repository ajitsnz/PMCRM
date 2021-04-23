<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Comment
 *
 * @package App\Models
 * @version April 20, 2020, 8:27 am UTC
 * @property int $id
 * @property string $description
 * @property int $owner_id
 * @property string $owner_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereDescription($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereOwnerId($value)
 * @method static Builder|Comment whereOwnerType($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $added_by
 * @method static Builder|Comment whereAddedBy($value)
 * @property-read \App\Models\User $user
 */
class Comment extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required',
    ];

    public $table = 'comments';

    public $fillable = [
        'description',
        'owner_id',
        'owner_type',
        'added_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
