<?php

namespace App\Models;

use App\Models\Contracts\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * Class Ticket
 *
 * @package App\Models
 * @version April 8, 2020, 6:13 am UTC
 * @property string $subject
 * @property int|null $contact_id
 * @property string $name
 * @property string|null $email
 * @property int|null $department_id
 * @property string|null $cc
 * @property int|null $assign_to
 * @property int $priority_id
 * @property int $service_id
 * @property int|null $predefined_reply_id
 * @property string attachments
 * @property int $id
 * @property string|null $body
 * @property int|null $ticket_status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\PredefinedReply|null $predefinedReply
 * @property-read \App\Models\Service $service
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereAssignTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket wherePredefinedReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\TicketPriority $ticketPriority
 * @property-read \App\Models\TicketStatus $ticketStatus
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereTicketStatusId($value)
 * @property-read \App\Models\Contact|null $contact
 * @property-read bool|string $ticket_attachments
 */
class Ticket extends Model implements HasMedia, Taggable
{
    use HasMediaTrait;

    public const TICKET_ATTACHMENT_PATH = 'tickets';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject'     => 'required|unique:tickets,subject',
        'email'       => 'nullable|email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/',
        'cc'          => 'nullable|email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/',
    ];

    public $table = 'tickets';

    public $fillable = [
        'subject',
        'contact_id',
        'name',
        'email',
        'department_id',
        'cc',
        'assign_to',
        'priority_id',
        'service_id',
        'predefined_reply_id',
        'body',
        'ticket_status_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'subject'     => 'string',
        'name'        => 'string',
        'priority_id' => 'integer',
        'service_id'  => 'integer',
    ];

    /**
     * @var array
     */
    protected $appends = ['ticket_attachments'];

    /**
     *
     * @return bool|string
     */
    public function getTicketAttachmentsAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(Ticket::TICKET_ATTACHMENT_PATH)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return false;
    }

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * @return BelongsTo
     */
    public function ticketPriority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    /**
     * @return BelongsTo
     */
    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_status_id');
    }

    /**
     * @return BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    /**
     * @return BelongsTo
     */
    public function predefinedReply()
    {
        return $this->belongsTo(PredefinedReply::class, 'predefined_reply_id');
    }

    /**
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOwnerType()
    {
        return Ticket::class;
    }

    /**
     *
     * @return HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'owner_id');
    }
}
