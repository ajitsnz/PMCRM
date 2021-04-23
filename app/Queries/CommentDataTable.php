<?php

namespace App\Queries;

use App\Models\Comment;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CommentDataTable
 */
class CommentDataTable
{
    /**
     * @param  array  $input
     *
     * @return Comment|Builder
     */
    public function get($input = [])
    {
        /** @var Comment $query */
        $query = Comment::with('user')->select('comments.*')
            ->where('owner_id', '=', $input['owner_id'])
            ->where('owner_type', '=', Reminder::REMINDER_MODULES[$input['module_id']]);

        return $query;
    }
}
