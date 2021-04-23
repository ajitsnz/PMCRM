<?php

namespace App\Console\Commands;

use App\Repositories\AnnouncementRepository;
use Illuminate\Console\Command;

/**
 * Class AnnouncementNotification
 */
class AnnouncementReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:appointment-reminder-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Announcement Reminder Email';


    /**
     * @var AnnouncementRepository
     */
    private $announcementRepository;


    /**
     * Create a new command instance.
     *
     * @param  AnnouncementRepository  $announcementRepository
     */
    public function __construct(AnnouncementRepository $announcementRepository)
    {
        parent::__construct();
        $this->announcementRepository = $announcementRepository;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Sending Announcement Reminder Emails...');
        $this->announcementRepository->sendAnnouncementReminderEmail();

        $this->info('Announcement Reminder Emails Sent Successfully!');

        return true;
    }
}
