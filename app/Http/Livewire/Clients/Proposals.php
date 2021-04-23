<?php

namespace App\Http\Livewire\Clients;

use App\Http\Livewire\SearchableComponent;
use App\Models\Proposal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Proposals extends SearchableComponent
{
    public $paginate = 9;

    public $statusFilter = '';

    public function render()
    {
        $proposals = $this->searchProposals();

        return view('livewire.clients.proposals', [
            'proposals' => $proposals,
        ])->with("search");
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchProposals()
    {
        $owner_id = Auth::user()->contact->customer_id;

        $this->setQuery($this->getQuery()->with('customer')->where('owner_id', $owner_id)->where('status', '!=',
            Proposal::STATUS_DRAFT));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('status', $this->statusFilter);
        });

        return $this->paginate();
    }

    function filterProposalStatus($id)
    {
        $this->statusFilter = $id;
    }

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterProposalStatus',
    ];

    /**
     * @return mixed|string
     */
    function model()
    {
        return Proposal::class;
    }

    /**
     * @return mixed|string[]
     */
    function searchableFields()
    {
        return [
            'title',
            'proposal_number',
            'total_amount',
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
