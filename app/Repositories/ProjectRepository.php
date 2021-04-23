<?php

namespace App\Repositories;

use App\Mail\ProjectMail;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Tag;
use App\Models\User;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

/**
 * Class ProjectRepository
 * @package App\Repositories
 * @version April 16, 2020, 5:45 am UTC
 */
class ProjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'progress',
        'billing_type',
        'status',
        'estimate_hours',
        'start_date',
        'deadline',
        'description',
        'send',
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
        return Project::class;
    }

    /**
     *
     * @param  null  $customerId
     *
     * @return mixed
     */
    public function getProjectsStatusCount($customerId = null)
    {
        if (! empty($customerId)) {
            return Project::selectRaw('count(case when status = 0 then 1 end) as not_started')
                ->selectRaw('count(case when status = 1 then 1 end) as in_progress')
                ->selectRaw('count(case when status = 2 then 1 end) as on_hold')
                ->selectRaw('count(case when status = 3 then 1 end) as cancelled')
                ->selectRaw('count(case when status = 4 then 1 end) as finished')
                ->selectRaw('count(*) as total_projects')
                ->where('customer_id', '=', $customerId)->first();
        }

        return Project::selectRaw('count(case when status = 0 then 1 end) as not_started')
            ->selectRaw('count(case when status = 1 then 1 end) as in_progress')
            ->selectRaw('count(case when status = 2 then 1 end) as on_hold')
            ->selectRaw('count(case when status = 3 then 1 end) as cancelled')
            ->selectRaw('count(case when status = 4 then 1 end) as finished')
            ->selectRaw('count(*) as total_projects')
            ->first();
    }

    /**
     * @return mixed
     */
    public function getSyncList()
    {
        $data['customers'] = Customer::pluck('company_name', 'id')->toArray();
        $data['contacts'] = User::with('owner')->whereOwnerType(Contact::class)
            ->whereIsEnable(true)
            ->get()
            ->pluck('full_name', 'owner.id')
            ->toArray();
        $data['members'] = User::whereIsEnable(true)
            ->user()
            ->get()
            ->pluck('full_name', 'id')
            ->toArray();
        $data['billingTypes'] = Project::BILLING_TYPES;
        $data['status'] = Project::STATUS;
        $data['tags'] = Tag::pluck('name', 'id')->toArray();

        return $data;
    }

    /**
     * @param  array  $input
     */
    public function saveProject($input)
    {
        $projectInputs = Arr::except($input, ['tags', 'members']);

        $projectInputs['calculate_progress_through_tasks'] = isset($projectInputs['calculate_progress_through_tasks']) ? 1 : 0;
        $projectInputs['send_email'] = isset($projectInputs['send_email']) ? 1 : 0;

        /** @var Project $project */
        $project = $this->create($projectInputs);

        activity()->performedOn($project)->causedBy(getLoggedInUser())
            ->useLog('New Project created.')->log($project->project_name.' Project created.');

        if (! empty($input['members'])) {
            $this->storeProjectMembers($input, $project);
        }

        if (isset($input['contacts']) && ! empty($input['contacts'])) {
            $project->projectContacts()->sync($input['contacts']);
        }

        if (isset($input['tags']) && ! empty($input['tags'])) {
            $project->tags()->sync($input['tags']);
        }
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function getProjectData($id)
    {
        $project = Project::with(['tags'])->select('projects.*')->find($id);

        return $project;
    }

    /**
     * @param  int  $id
     *
     * @param $input
     *
     * @return Builder|Builder[]|Collection|Model
     */
    public function updateProject($id, $input)
    {
        $projectInputs = Arr::except($input, ['members', 'tags']);
        $projectInputs['calculate_progress_through_tasks'] = isset($input['calculate_progress_through_tasks']) ? 1 : 0;
        $projectInputs['progress'] = isset($input['progress']) ? $input['progress'] : 0;

        $projectInputs['send_email'] = isset($input['send_email']) ? 1 : 0;

        /** @var Project $project */
        $project = $this->update($projectInputs, $id);

        activity()->performedOn($project)->causedBy(getLoggedInUser())
            ->useLog('Project updated.')->log($project->project_name.' Project updated.');

        if (! empty($input['members'])) {
            $this->updateProjectMembers($input, $project);
        }

        if (isset($input['contacts']) && ! empty($input['contacts'])) {
            $project->projectContacts()->sync($input['contacts']);
        }

        if (isset($input['tags']) && ! empty($input['tags'])) {
            $project->tags()->sync($input['tags']);
        }

        return $project;
    }

    /**
     * @param  array  $input
     *
     * @param  Project  $project
     *
     * @return bool
     */
    public function storeProjectMembers($input, $project)
    {
        $project->members()->delete();

        foreach ($input['members'] as $record) {
            $data['owner_id'] = $project->getId();
            $data['owner_type'] = $project->getOwnerType();
            $data['user_id'] = $record;
            $projectMember = ProjectMember::create($data);

            if (isset($input['send_email']) && $input['send_email']) {
                Mail::to($projectMember->user->email)->send(new ProjectMail($project, $projectMember));
            }
        }

        return true;
    }

    /**
     * @param $input
     *
     * @param $project
     *
     * @return bool
     */
    public function updateProjectMembers($input, $project)
    {
        $project->members()->delete();
        $existUserIds = $project->members->pluck('user_id')->toArray();

        foreach ($input['members'] as $record) {
            $data['owner_id'] = $project->getId();
            $data['owner_type'] = $project->getOwnerType();
            $data['user_id'] = $record;
            $projectMember = ProjectMember::create($data);

            if ($project->send_email && ! in_array($record, $existUserIds)) {
                Mail::to($projectMember->user->email)->send(new ProjectMail($project, $projectMember));
            }
        }

        return true;
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function getProjectDetails($id)
    {
        $project = Project::with('tags', 'projectContacts.user', 'members.user', 'customer')->find($id);

        return $project;
    }

}
