<?php

namespace App\Queries\Clients;

use App\Models\Reminder;
use App\Models\Task;

/**
 * Class ReminderDataTable
 */
class ReminderDataTable
{
    /**
     * @param  array  $input
     *
     * @return Reminder
     */
    public function get($input = [])
    {
        /** @var Reminder $query */
        $query = Reminder::with('user')->select('reminders.*')
            ->where('owner_id', '=', $input['owner_id'])
            ->where('owner_type', '=', Task::class);

        return $query;
    }
}
