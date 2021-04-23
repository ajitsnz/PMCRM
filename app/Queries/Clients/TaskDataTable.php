<?php

namespace App\Queries\Clients;

use App\Models\Task;

/**
 * Class TaskDataTable
 */
class TaskDataTable
{
    /**
     * @param  array  $input
     *
     * @return Task
     */
    public function get($input = [])
    {
        /** @var Task $query */

        $query = Task::with('user')->select('tasks.*')->where('owner_id', '=', $input['owner_id'])
            ->where('owner_type', '=', $input['owner_type']);

        return $query;
    }
}
