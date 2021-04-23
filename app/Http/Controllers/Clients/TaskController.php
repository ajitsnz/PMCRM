<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Reminder;
use App\Models\Task;
use App\Queries\Clients\TaskDataTable;
use App\Repositories\TaskRepository;
use App\Repositories\TicketRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\DataTables;

/**
 * Class TaskController
 */
class TaskController extends AppBaseController
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the Task.
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
            return DataTables::of((new TaskDataTable())->get($request->only([
                'owner_id', 'owner_type',
            ])))->make(true);
        }

        $status = Task::STATUS;
        $priorities = Task::PRIORITY;

        return view('clients.tasks.index', compact('status', 'priorities'));
    }

    /**
     * Display the specified Task.
     *
     * @param  Task  $task
     *
     * @return Factory|View
     */
    public function show(Task $task)
    {
        $ticketRepo = App::make(TicketRepository::class);
        $data = $ticketRepo->getReminderData($task->id, Task::class);
        $notifiedReminder = Reminder::IS_NOTIFIED;
        $comments = $this->taskRepository->getCommentData($task);
        $groupName = (request('group') === null) ? 'task_details' : (request('group'));

        return view("clients.tasks.views.$groupName",
            compact('task', 'data', 'notifiedReminder', 'comments', 'groupName'));
    }
}
