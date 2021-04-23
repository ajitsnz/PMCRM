<?php

namespace App\Http\Livewire;

use App\Models\Goal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Goals extends SearchableComponent
{
    public $search = '';

    public $statusFilter = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh', 'filterStatus',
    ];
    
    public function render()
    {
        $goals = $this->search();
        
        return view('livewire.goals',['goals' => $goals]);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function search()
    {
        $this->setQuery($this->getQuery()->with('goalMembers.media')->orderByDesc('subject'));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('goal_type', $this->statusFilter);
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
        return Goal::class;
    }

    /**
     * @return mixed|string[]
     */
    function searchableFields()
    {
        return [
          'subject',
        ];
    }
}
