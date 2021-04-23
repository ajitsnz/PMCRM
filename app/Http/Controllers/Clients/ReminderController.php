<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Queries\Clients\ReminderDataTable;
use App\Repositories\ReminderRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class ReminderController
 */
class ReminderController extends AppBaseController
{
    /**
     * @var ReminderRepository
     */
    private $reminderRepository;

    function __construct(ReminderRepository $reminderRepository)
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
            return DataTables::of((new ReminderDataTable())->get($request->only(['owner_id'])))->make(true);
        }

        return view('clients.reminders.index');
    }
}
