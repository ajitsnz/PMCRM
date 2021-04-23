<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ContactEmailNotification
 *
 * @property int $id
 * @property int $contact_id
 * @property int $email_notification_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification
 *     whereEmailNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactEmailNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactEmailNotification extends Model
{
    public $table = 'contact_email_notifications';

    public $fillable = [
        'contact_id',
        'email_notification_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                    => 'integer',
        'contact_id'            => 'integer',
        'email_notification_id' => 'integer',
    ];
}
