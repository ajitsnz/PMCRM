<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmailNotification
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailNotification query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailNotification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailNotification whereUpdatedAt($value)
 */
class EmailNotification extends Model
{
    public $table = 'email_notifications';

    public $fillable = [
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
