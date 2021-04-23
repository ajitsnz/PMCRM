<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Department;
use App\Models\Note;
use App\Models\PredefinedReply;
use App\Models\Reminder;
use App\Models\Service;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class TicketRepository
 * @package App\Repositories
 * @version April 8, 2020, 6:13 am UTC
 */
class TicketRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        'attachments',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ticket::class;
    }

    /**
     * @param  null  $customerId
     *
     * @return mixed
     */
    public function getTicketStatusCounts($customerId = null)
    {
        if (isset($customerId)) {
            $data = TicketStatus::with([
                'tickets.contact' => function (BelongsTo $query) use ($customerId) {
                    $query->where('customer_id', '=', $customerId);
                },
            ])->withCount('tickets')->get();
        } else {
            $data = TicketStatus::withCount('tickets')->get();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getSyncList()
    {
        $data = [];
        $data['contacts'] = Contact::with('user')->get()->where('user.is_enable', '=', true)->pluck('user.full_name',
            'id');
        $data['departments'] = Department::pluck('name', 'id');
        $data['assignTo'] = User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id');
        $data['priority'] = TicketPriority::whereStatus(true)->pluck('name', 'id');
        $data['ticketStatus'] = TicketStatus::pluck('name', 'id');
        $data['services'] = Service::all()->pluck('name', 'id');
        $data['tags'] = Tag::pluck('name', 'id')->toArray();
        $data['predefinedReplies'] = PredefinedReply::all()->pluck('reply_name', 'id');

        return $data;
    }

    /**
     * @param  int  $id
     *
     * @param  string  $class
     *
     * @return array
     */
    public function getReminderData($id, $class)
    {
        $data = [];
        $data['reminderTo'] = User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id');
        $data['ownerId'] = $id;

        foreach (Reminder::REMINDER_MODULES as $key => $value) {
            if ($value == $class) {
                $data['moduleId'] = $key;
                break;
            }
        }

        return $data;
    }

    /**
     * @param  array  $input
     *
     * @return void
     */
    public function create($input)
    {
        try {
            $ticketInput = Arr::except($input, ['tags', 'attachments']);
            $tagsInput = Arr::only($input, ['tags']);
            $attachmentsInput = Arr::only($input, ['attachments']);

            /** @var Ticket $ticket */
            $ticket = Ticket::create($ticketInput);

            activity()->performedOn($ticket)->causedBy(getLoggedInUser())
                ->useLog('New Ticket created.')->log($ticket->subject.' Ticket created.');

            if (isset($input['tags']) && ! empty($tagsInput)) {
                $ticket->tags()->sync($input['tags']);
            }

            if (! empty($attachmentsInput)) {
                foreach ($attachmentsInput['attachments'] as $attachment) {
                    $ticket->addMedia($attachment)->toMediaCollection(Ticket::TICKET_ATTACHMENT_PATH,
                        config('app.media_disc'));
                }
            }

        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param  array  $input
     *
     * @param  Ticket  $ticket
     *
     * @return void
     */
    public function update($input, $ticket)
    {
        try {
            $ticketInput = Arr::except($input, ['tags', 'attachments']);
            $tagsInput = Arr::only($input, ['tags']);
            $attachmentsInput = Arr::only($input, ['attachments']);

            /** @var Ticket $ticket */
            $ticket->update($ticketInput);

            activity()->performedOn($ticket)->causedBy(getLoggedInUser())
                ->useLog('Ticket updated.')->log($ticket->subject.' Ticket updated.');

            if (isset($input['tags']) && ! empty($tagsInput)) {
                $ticket->tags()->sync($input['tags']);
            }

            if (! empty($attachmentsInput)) {
                foreach ($attachmentsInput['attachments'] as $attachment) {
                    $ticket->addMedia($attachment)->toMediaCollection(Ticket::TICKET_ATTACHMENT_PATH,
                        config('app.media_disc'));
                }
            }

        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param $ticket
     *
     * @return Builder[]|Collection
     */
    public function getNotesData($ticket)
    {
        return Note::with('user.media')->where('owner_id', '=', $ticket->id)
            ->where('owner_type', '=', Ticket::class)->orderByDesc('created_at')->get();
    }
}
