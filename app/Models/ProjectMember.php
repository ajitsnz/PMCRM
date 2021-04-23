<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProjectMember
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectMember whereUserId($value)
 * @mixin \Eloquent
 */
class ProjectMember extends Model
{
    /**
     * @var string 
     */
    public $table = 'project_members';

    /**
     * @var array 
     */
    public $fillable = [
        'owner_id',
        'owner_type',
        'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
