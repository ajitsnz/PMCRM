<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Models\Reminder;
use App\Queries\ReminderDataTable;
use App\Repositories\ReminderRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ReminderController extends AppBaseController
{
    /** @var  ReminderRepository */
    private $reminderRepository;

    public function __construct(ReminderRepository $reminderRepository)
    {
        $this->reminderRepository = $reminderRepository;
    }

    /**
     * Display a listing of the Reminder.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ReminderDataTable())->get($request->only([
                'module_id', 'owner_id', 'is_notified',
            ])))->make(true);
        }

        $notifiedReminder = Reminder::IS_NOTIFIED;

        return view('reminders.index', compact('notifiedReminder'));
    }

    /**
     * Store a newly created Reminder in storage.
     *
     * @param  CreateReminderRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateReminderRequest $request)
    {
        $input = $request->all();
        $input['status'] = Reminder::PENDING;
        $this->reminderRepository->store($input);

        return $this->sendSuccess('Reminder saved successfully.');
    }

    /**
     * Show the form for editing the specified Reminder.
     *
     * @param  Reminder  $reminder
     *
     * @return JsonResponse
     */
    public function edit(Reminder $reminder)
    {
        return $this->sendResponse($reminder, 'Reminder retrieved successfully.');
    }

    /**
     * Update the specified Reminder in storage.
     *
     * @param  UpdateReminderRequest  $request
     *
     * @param  Reminder  $reminder
     *
     * @return JsonResponse
     */
    public function update(UpdateReminderRequest $request, Reminder $reminder)
    {
        $input = $request->all();
        $input['status'] = (isset($input['status'])) ? 1 : 0;
        $this->reminderRepository->update($input, $reminder);

        return $this->sendSuccess('Reminder updated successfully.');
    }

    /**
     * Remove the specified Reminder from storage.
     *
     * @param  Reminder  $reminder
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Reminder $reminder)
    {
        activity()->performedOn($reminder)->causedBy(getLoggedInUser())
            ->useLog('Reminder deleted.')->log(html_entity_decode($reminder->description).' Reminder deleted.');

        $reminder->delete();

        return $this->sendSuccess('Reminder deleted successfully.');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeActiveNotified($id)
    {
        $reminder = Reminder::find($id);
        $reminder->update(['is_notified' => ! $reminder->is_notified]);

        return $this->sendSuccess('Reminder updated successfully.');
    }

    /**
     * @param  Reminder  $reminder
     *
     * @return mixed
     */
    public function statusChange(Reminder $reminder)
    {
        $reminder = Reminder::find($reminder->id);
        $reminder->update(['status' => ! $reminder->status]);

        return $this->sendSuccess('Reminder status updated successfully.');
    }
}
