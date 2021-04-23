<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Queries\NoteDataTable;
use App\Repositories\NoteRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class NoteController extends AppBaseController
{
    /** @var  NoteRepository $noteRepository */
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * Display a listing of the Note.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new NoteDataTable())->get($request->only([
                'module_id', 'owner_id',
            ])))->make(true);
        }
    }

    /**
     * Store a newly created Note in storage.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $note = $this->noteRepository->create($input);

        return $this->sendResponse($note, 'Note saved successfully.');
    }

    /**
     * Show the form for editing the specified Note.
     *
     * @param  Note  $note
     *
     * @return JsonResponse
     */
    public function edit(Note $note)
    {
        return $this->sendResponse($note, 'Note retrieved successfully.');
    }

    /**
     * Update the specified Note in storage.
     *
     * @param  Request  $request
     *
     * @param  Note  $note
     *
     * @return JsonResponse
     */
    public function update(Request $request, Note $note)
    {
        $input = $request->all();
        $note = $this->noteRepository->update($input, $note->id);

        activity()->performedOn($note)->causedBy(getLoggedInUser())
            ->useLog('Note updated.')
            ->log($note->note.' Note updated.');

        return $this->sendSuccess('Note updated successfully.');
    }

    /**
     * Remove the specified Note from storage.
     *
     * @param  Note  $note
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Note $note)
    {
        activity()->performedOn($note)->causedBy(getLoggedInUser())
            ->useLog('Note deleted.')
            ->log($note->note.' Note deleted.');

        $note->delete();

        return $this->sendSuccess('Note deleted successfully.');
    }
}
