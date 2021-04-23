<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Reminder;
use App\Models\Task;
use App\Queries\TaskDataTable;
use App\Repositories\TaskRepository;
use App\Repositories\TicketRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends AppBaseController
{
    /** @var  TaskRepository $taskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
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
                'owner_id', 'owner_type', 'status', 'priority', 'member_id',
            ])))->make(true);
        }

        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $statusCount = $this->taskRepository->getStatusCount();

        return view('tasks.index', compact('status', 'priorities', 'statusCount'));
    }

    /**
     * Show the form for creating a new Task.
     *
     * @param  null  $relatedTo
     * @param  null  $customerId
     *
     * @return Factory|View
     */
    public function create($relatedTo = null, $customerId = null)
    {
        $data = $this->taskRepository->getData();

        return view('tasks.create', compact('data', 'relatedTo', 'customerId'));
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param  CreateTaskRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateTaskRequest $request)
    {
        $input = $request->all();
        $input['hourly_rate'] = removeCommaFromNumbers($input['hourly_rate']);

        $this->taskRepository->store($input);

        Flash::success('Task saved successfully.');

        return redirect(route('tasks.index'));
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
        /** @var TicketRepository $ticketRepo */
        $ticketRepo = App::make(TicketRepository::class);
        $data = $ticketRepo->getReminderData($task->id, Task::class);
        $notifiedReminder = Reminder::IS_NOTIFIED;
        $comments = $this->taskRepository->getCommentData($task);

        $groupName = (request('group') === null) ? 'task_details' : (request('group'));

        return view("tasks.views.$groupName", compact('task', 'data', 'notifiedReminder', 'comments', 'groupName'));
    }

    /**
     * Show the form for editing the specified Task.
     *
     * @param  Task  $task
     *
     * @return Factory|View
     */
    public function edit(Task $task)
    {
        $data = $this->taskRepository->getData();
        $owner = $this->taskRepository->getOwner(! empty($task['related_to']) ? $task['related_to'] : null);

        return view('tasks.edit', compact('task', 'data', 'owner'));
    }

    /**
     * Update the specified Task in storage.
     *
     * @param  Task  $task
     *
     * @param  UpdateTaskRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Task $task, UpdateTaskRequest $request)
    {
        $input = $request->all();

        $input['hourly_rate'] = removeCommaFromNumbers($input['hourly_rate']);

        $this->taskRepository->update($input, $task);

        Flash::success('Task updated successfully.');

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified Task from storage.
     *
     * @param  Task  $task
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Task $task)
    {
        activity()->performedOn($task)->causedBy(getLoggedInUser())
            ->useLog('Task deleted.')->log($task->subject.' Task deleted.');

        $this->taskRepository->delete($task->id);

        return $this->sendSuccess('Task deleted successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function changeOwner(Request $request)
    {
        $id = $request->get('id');

        $owner = $this->taskRepository->getOwner($id);

        return $this->sendResponse($owner, 'retrieved successfully');
    }

    /**
     * @param  Task  $task
     *
     * @param  int  $status
     *
     * @return JsonResponse
     */
    public function changeStatus(Task $task, $status)
    {
        $task->update(['status' => $status]);

        return $this->sendSuccess('Task status updated successfully.');
    }

    /**
     *
     * @return Factory|View
     */
    public function kanbanList()
    {
        /** @var Task[] $tasks */
        $tasks = Task::with(['user.media'])->get()->groupBy('status');

        $taskStatus = Task::STATUS;

        return view('tasks.kanban.index', compact('tasks', 'taskStatus'));
    }

    /**
     * @param  Task  $task
     *
     * @return mixed
     */
    public function getCommentsCount(Task $task)
    {
        return $this->sendResponse($task->comments()->count(), 'Comments count retrieved successfully.');
    }
}
