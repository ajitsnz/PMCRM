<?php

namespace App\Repositories;

use App\Models\Note;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class TagRepository
 */
class NoteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'note',
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
        return Note::class;
    }

    /**
     * @param  array  $input
     *
     * @return Model|null
     */
    public function create($input)
    {
        $input['owner_type'] = Reminder::REMINDER_MODULES[$input['module_id']];
        $input['added_by'] = Auth::user()->id;
        $note = Note::create($input);

        activity()->performedOn($note)->causedBy(getLoggedInUser())
            ->useLog('New Note created.')
            ->log($note->note.' Note created.');

        return Note::with('user')->findOrFail($note->id);
    }
}
