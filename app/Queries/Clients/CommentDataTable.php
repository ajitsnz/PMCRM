<?php

namespace App\Queries\Clients;

use App\Models\Comment;
use App\Models\Task;

/**
 * Class CommentDataTable
 */
class CommentDataTable
{
    /**
     * @param  array  $input
     *
     * @return Comment
     */
    public function get($input = [])
    {
        /** @var Comment $query */
        $query = Comment::with('user')->select('comments.*')
            ->where('owner_id', '=', $input['owner_id'])
            ->where('owner_type', '=', Task::class);

        return $query;
    }
}
