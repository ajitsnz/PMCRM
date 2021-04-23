<?php

namespace App\Repositories;

use App\Mail\ReminderMail;
use App\Models\Reminder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ReminderRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:24 am UTC
 */
class ReminderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'notified_date',
        'reminder_to',
        'description',
        'is_notified',
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
        return Reminder::class;
    }

    /**
     * @param  array  $input
     *
     * @return bool
     */
    public function store($input)
    {
        $input['owner_type'] = Reminder::REMINDER_MODULES[$input['module_id']];
        $input['added_by'] = Auth::user()->id;
        $reminder = Reminder::create($input);

        activity()->performedOn($reminder)->causedBy(getLoggedInUser())
            ->useLog('New Reminder created.')->log(html_entity_decode($reminder->description).' Reminder created.');

        if (isset($input['is_notified'])) {
            Mail::to($reminder->user->email)->send(new ReminderMail($reminder));
            $reminder->update(['is_notified' => 1]);
        }

        return true;
    }

    /**
     * @param  array  $input
     *
     * @param  Reminder  $reminder
     *
     * @return bool
     */
    public function update($input, $reminder)
    {

        $reminder->update($input);

        activity()->performedOn($reminder)->causedBy(getLoggedInUser())
            ->useLog('Reminder updated.')->log(htmlspecialchars_decode($reminder->description).' Reminder updated.');

        if (isset($input['is_notified']) && $reminder->is_notified != 1) {
            Mail::to($reminder->user->email)->send(new ReminderMail($reminder));
            $reminder->update(['is_notified' => 1]);
        }

        return true;
    }

    public function sendReminderEmail()
    {
        /** @var Reminder $reminders */
        $reminders = Reminder::with('contact.user')->where('status', Reminder::PENDING)
            ->where('is_notified', true)
            ->where('notified_date', '<=', Carbon::now()->toDateTimeString())
            ->get();
        
        foreach ($reminders as $reminder) {
            $updateStatus = Reminder::whereId($reminder->id)->update(['status' => Reminder::COMPLETED,'is_notified' => 1]);
            try {
                if(!empty($reminder->contact->user->email)){
                    Mail::to($reminder->contact->user->email)->send(new ReminderMail($reminder));
                }
            } catch (\Exception $e) {
                throw new UnprocessableEntityHttpException($e->getMessage());
            }
        }
    }
}
