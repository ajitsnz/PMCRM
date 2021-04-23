<?php

namespace App\Repositories;

use App\Mail\AnnouncementReminderMail;
use App\Models\Announcement;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class AnnouncementRepository
 * @package App\Repositories
 * @version April 6, 2020, 6:50 am UTC
 */
class AnnouncementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
        'message',
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
        return Announcement::class;
    }

    public function sendAnnouncementReminderEmail()
    {
        /** @var Announcement $announcement */
        $announcements = Announcement::where('status', Announcement::PENDING)
            ->where('show_to_clients', true)
            ->whereDate('date', '<=', Carbon::now()->toDateString())
            ->get();

        $contacts = User::whereOwnerType(Contact::class)->where('is_enable',
            true)->whereNotNull('email_verified_at')->pluck('email');


        foreach ($announcements as $announcement) {
            $updateStatus = Announcement::whereId($announcement->id)->update(['status' => Announcement::COMPLETED]);
            foreach ($contacts as $contact) {
                try {

                    $input['message'] = $announcement->message;
                    $input['subject'] = $announcement->subject;
                    $input['created_at'] = $announcement->created_at;

                    Mail::to($contact)
                        ->send(new AnnouncementReminderMail('emails.reminder.announcement',
                            'Announcement Notification',
                            $input));

                } catch (\Exception $e) {
                    throw new UnprocessableEntityHttpException($e->getMessage());
                }
            }
        }
    }
}
