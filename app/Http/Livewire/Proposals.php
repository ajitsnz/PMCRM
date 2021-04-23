<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Proposal;
use App\Repositories\ProposalRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Proposals extends SearchableComponent
{
    public $statusFilter = '';
    public $customer = '';
    public $lead = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterProposalStatus',
    ];

    /**
     *
     * @return string
     */
    public function model()
    {
        return Proposal::class;
    }

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return [
            'title',
            'proposal_number',
        ];
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $proposals = $this->searchProposals();
        $proposalRepo = app(ProposalRepository::class);
        $statusCount = $proposalRepo->getProposalsStatusCount();
        $customer = $this->customer;
        $lead = $this->lead;
        $proposalStatus = Proposal::STATUS;

        return view('livewire.proposals', compact('proposals', 'statusCount', 'customer', 'proposalStatus'));
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchProposals()
    {
        $this->setQuery($this->getQuery()->with(['customer', 'lead']));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('status', $this->statusFilter);
        });

        $this->getQuery()->when($this->customer !== '', function (Builder $q) {
            $q->where('owner_id', $this->customer)
                ->where('owner_type', Customer::class);
        });

        $this->getQuery()->when($this->lead !== '', function (Builder $q) {
            $q->where('owner_id', $this->lead)
                ->where('owner_type', Lead::class);
        });

        return $this->paginate();
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

    /**
     * @param  int  $id
     */
    public function filterProposalStatus($id)
    {
        $this->statusFilter = $id;
    }
}
