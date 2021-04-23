<?php

namespace App\Console\Commands;

use App\Repositories\ReminderRepository;
use Illuminate\Console\Command;

/**
 * Class ReminderMainSend
 */
class ReminderMainSend  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder Email';

    /**
     * @var ReminderRepository
     */
    private $reminderRepository;

    /**
     * Create a new command instance.
     *
     * @param  ReminderRepository  $reminderRepository
     */
    public function __construct(ReminderRepository $reminderRepository)
    {
        parent::__construct();
        $this->reminderRepository = $reminderRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Sending Reminder Emails...');
        $this->reminderRepository->sendReminderEmail();

        $this->info('Reminder Emails Sent Successfully!');

        return true;
    }
}
