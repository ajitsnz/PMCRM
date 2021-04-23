<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Task;
use App\Queries\ProjectDataTable;
use App\Repositories\ProjectRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Redirect;
use Yajra\DataTables\DataTables;

class ProjectController extends AppBaseController
{
    /** @var  ProjectRepository */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepository = $projectRepo;
    }

    /**
     * Display a listing of the Project.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return DataTables::of((new ProjectDataTable())->get($request->only(['status','customer_id'])))->make(true);
        }

        $data['statusCount'] = $this->projectRepository->getProjectsStatusCount();
        $data['statusArr'] = Project::STATUS;
        $data['billingType'] = Project::BILLING_TYPES;

        return view('projects.index', $data);
    }

    /**
     * Show the form for creating a new Project.
     *
     * @param  null  $customerId
     *
     * @return Application|Factory|View
     */
    public function create($customerId = null)
    {
        $data = $this->projectRepository->getSyncList();

        return view('projects.create', compact('data', 'customerId'));
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param  CreateProjectRequest  $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateProjectRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();

            $this->projectRepository->saveProject($input);
            DB::commit();

            Flash::success('Project saved successfully.');

            return redirect(route('projects.index'));
        } catch (Exception $e) {
            DB::rollBack();

            return Redirect::back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified Project.
     *
     * @param  Project  $project
     *
     * @return Application|Factory|View
     */
    public function show(Project $project)
    {
        $project = $this->projectRepository->getProjectDetails($project->id);
        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $groupName = (request('group') === null) ? 'project_details' : (request('group'));

        return view("projects.views.$groupName", compact('project', 'status', 'priorities', 'groupName'));
    }

    /**
     * Show the form for editing the specified Project.
     *
     * @param  Project  $project
     *
     * @return RedirectResponse
     */
    public function edit(Project $project)
    {
        if ($project->status == Project::STATUS_CANCELLED) {
            return redirect()->back();
        }

        $data = $this->projectRepository->getSyncList();
        $project = $this->projectRepository->getProjectData($project->id);
        $data['projectContacts'] = $project->projectContacts()->pluck('contact_id')->toArray();

        return view('projects.edit', compact('data', 'project'));
    }

    /**
     * Update the specified Project in storage.
     *
     * @param  Project  $project
     *
     * @param  UpdateProjectRequest  $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $input = $request->all();

        $this->projectRepository->updateProject($project->id, $input);

        Flash::success('Project updated successfully.');

        return redirect(route('projects.index'));
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function memberAsPerCustomer(Request $request)
    {
        /** @var Contact $contact */
        $contact = Contact::with('user')->whereCustomerId($request->get('customer_id'))->get();
        $members = $contact->where('user.is_enable', '=', true)->pluck('user.full_name', 'id')->toArray();

        return $this->sendResponse($members, 'member retrieved data success.');
    }
}
