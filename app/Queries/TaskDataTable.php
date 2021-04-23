<?php

namespace App\Queries;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TaskDataTable
 */
class TaskDataTable
{
    /**
     * @param  array  $input
     *
     * @return Task|Builder
     */
    public function get($input = [])
    {
        /** @var Task $query */
        $query = Task::with(['user'])->select('tasks.*');

        $query->when($input['owner_id'] != null, function (Builder $q) use ($input) {
            $q->where('owner_type', '=', $input['owner_type'])
                ->where('owner_id', '=', $input['owner_id']);
        });

        $query->when(isset($input['status']) && $input['status'] != Task::STATUS,
            function (Builder $q) use ($input) {
                $q->where('status', '=', $input['status']);
            });

        $query->when(isset($input['priority']) && $input['priority'] != Task::PRIORITY,
            function (Builder $q) use ($input) {
                $q->where('priority', '=', $input['priority']);
            });

        $query->when(isset($input['member_id']), function (Builder $q) use ($input) {
            $q->where('member_id', '=', $input['member_id']);
        });

        return $query;
    }
}
