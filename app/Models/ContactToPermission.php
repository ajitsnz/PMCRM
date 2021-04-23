<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ContactToPermission
 *
 * @property int $id
 * @property int $contact_id
 * @property int $permission_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactToPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactToPermission extends Model
{
    public $table = 'contact_to_permissions';

    public $fillable = [
        'contact_id',
        'permission_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'contact_id'    => 'integer',
        'permission_id' => 'integer',
    ];
}
