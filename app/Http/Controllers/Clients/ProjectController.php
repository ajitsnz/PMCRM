<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Project;
use App\Queries\Clients\ProjectDataTable;
use App\Repositories\ProjectRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

/**
 * Class ProjectController
 */
class ProjectController extends AppBaseController
{

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the Project.
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
            return DataTables::of((new ProjectDataTable())->get($request->only(['status'])))->make(true);
        }

        $data['statusCount'] = $this->projectRepository->getProjectsStatusCount(getLoggedInUser()->contact->customer_id);
        $data['statusArr'] = Project::STATUS;
        $data['billingType'] = Project::BILLING_TYPES;

        return view('clients.projects.index', $data);
    }

    /**
     * Display the specified Project.
     *
     * @param  Project  $project
     *
     * @return Factory|View
     */
    public function show(Project $project)
    {
        $project = $this->projectRepository->getProjectDetails($project->id);
        $groupName = (request('group') === null) ? 'project_details' : (request('group'));

        return view("clients.projects.views.$groupName", compact('project', 'groupName'));
    }
}
