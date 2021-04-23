<?php

namespace App\Queries;

use App\Models\Note;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class NoteDataTable
 */
class NoteDataTable
{
    /**
     * @param  array  $input
     *
     * @return Note|Builder
     */
    public function get($input = [])
    {
        /** @var Note $query */
        $query = Note::with('user')->select('notes.*');

        $query->when($input['owner_id'] != null, function (Builder $q) use ($input) {
            $q->where('owner_id', '=', $input['owner_id'])
                ->where('owner_type', '=', Reminder::REMINDER_MODULES[$input['module_id']]);
        });

        return $query;
    }
}
