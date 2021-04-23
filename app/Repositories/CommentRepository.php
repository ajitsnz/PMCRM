<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentRepository
 * @package App\Repositories
 * @version April 20, 2020, 8:27 am UTC
 */
class CommentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
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
        return Comment::class;
    }

    /**
     * @param  array  $input
     *
     * @return bool|Model
     */
    public function create($input)
    {
        $input['owner_type'] = Reminder::REMINDER_MODULES[$input['module_id']];
        $input['added_by'] = Auth::user()->id;
        $comment = Comment::create($input);

        activity()->performedOn($comment)->causedBy(getLoggedInUser())
            ->useLog('New Comment created.')
            ->log($comment->description.' Comment created.');

        return Comment::with('user')->findOrFail($comment->id);
    }
}
