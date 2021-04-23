<?php

namespace App\Http\Livewire;

use App\Models\Announcement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Announcements extends SearchableComponent
{
    public $statusFilter = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterStatus',
    ];

    /**
     *
     * @return string
     */
    public function model()
    {
        return Announcement::class;
    }

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return ['subject'];
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $announcements = $this->searchAnnouncements();

        return view('livewire.announcements', compact('announcements'));
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchAnnouncements()
    {
        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * @param  int  $Id
     */
    public function filterStatus($Id)
    {
        $this->statusFilter = $Id;
        $this->resetPage();
    }
}
