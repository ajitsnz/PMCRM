<?php

namespace App\Http\Livewire;

use App\Models\TicketPriority;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TicketPriorities extends SearchableComponent
{
    public $statusFilter = 2;

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterStatus',
    ];

    /**
     * @return string
     */
    public function model()
    {
        return TicketPriority::class;
    }

    /**
     * @return string[]
     */
    function searchableFields()
    {
        return ['name'];
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $ticketPriorities = $this->searchTicketPriorities();

        return view('livewire.ticket-priorities', compact('ticketPriorities'));
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchTicketPriorities()
    {
        $this->setQuery($this->getQuery()->withCount('tickets'));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter != 2, function (Builder $q) {
            $q->where('status', $this->statusFilter);
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
     * @param $statusId
     */
    public function filterStatus($statusId)
    {
        $this->statusFilter = $statusId;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
