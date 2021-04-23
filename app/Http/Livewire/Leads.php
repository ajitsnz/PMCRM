<?php

namespace App\Http\Livewire;


use App\Models\Lead;
use App\Repositories\LeadRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Leads extends SearchableComponent
{
    public $search = '';
    
    public $statusFilter = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh', 'filterStatus',
    ];

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $leads = $this->search();
        $leadRepo = app(LeadRepository::class);
        $data = $leadRepo->getLeadStatusCounts();

        return view('livewire.leads', ['leads' => $leads], compact('data'))->with('search');
    }

    /**
     * @return LengthAwarePaginator
     */
    public function search()
    {
        $this->setQuery($this->getQuery()->with(['leadSource','leadStatus','assignedTo.media'])->orderByDesc('name'));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('status_id', $this->statusFilter);
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
    function filterStatus($id)
    {
        $this->statusFilter = $id;
    }

    /**
     * @return mixed|string
     */
    function model()
    {
      return Lead::class;
    }

    /**
     * @return mixed|string[]
     */
    function searchableFields()
    {
        return [
            'name',
            'company_name',
        ];
    }
}
