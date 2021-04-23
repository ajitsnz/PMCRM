<?php

namespace App\Http\Livewire\Clients;

use App\Http\Livewire\SearchableComponent;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Projects extends SearchableComponent
{
    public $paginate = 9;

    public $statusFilter = '';
    public $billingType = '';

    public function render()
    {
        $projects = $this->searchProjects();
        $projectRepo = app(ProjectRepository::class);
        $data['statusCount'] = $projectRepo->getProjectsStatusCount(getLoggedInUser()->contact->customer_id);
        $data['search'] = '';

        return view('livewire.clients.projects', [
            'projects' => $projects,
        ])->with($data);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchProjects()
    {
        $this->setQuery($this->getQuery()->with(['customer','tags'])->whereHas('projectContacts', function (Builder $query) {
            $query->where('contact_id', '=', Auth::user()->owner_id);
        })->orderBy('created_at','DESC'));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('status', $this->statusFilter);
        });

        $this->getQuery()->when($this->billingType !== '', function (Builder $q) {
            $q->where('billing_type', $this->billingType);
        });
        
        return $this->paginate();
    }
    
    function filterProjectsByStatus($projectId)
    {
        $this->statusFilter = $projectId;
    }

    function filterProjectsByBillingType($projectId)
    {
        $this->billingType = $projectId;
    }

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterProjectsByStatus',
        'filterProjectsByBillingType',
    ];

    /**
     * @return mixed|string
     */
    function model()
    {
        return Project::class;
    }

    /**
     * @return mixed|string[]
     */
    function searchableFields()
    {
        return [
            'project_name',
        ];
    }

    /**
     *
     * @return Builder
     */
    public function filterResults()
    {
        $searchableFields = $this->searchableFields();
        $search = $this->search;

        $this->getQuery()->when(! empty($search), function (Builder $q) use ($search, $searchableFields) {
            $this->getQuery()->where(function (Builder $q) use ($search, $searchableFields) {
                $searchString = '%'.$search.'%';
                foreach ($searchableFields as $field) {
                    if (Str::contains($field, '.')) {
                        $field = explode('.', $field);
                        $q->orWhereHas($field[0], function (Builder $query) use ($field, $searchString) {
                            $query->whereRaw("lower($field[1]) like ?", $searchString);
                        });
                    } else {
                        $q->orWhereRaw("lower($field) like ?", $searchString);
                    }
                }
            });

        });

        return $this->getQuery();
    }
}
