<?php

namespace App\Http\Livewire\Clients;

use App\Http\Livewire\SearchableComponent;
use App\Models\Announcement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Announcements extends SearchableComponent
{
    public $statusFilter = '', $searchAnnouncement = '';
    public $paginate = 6;

    public function render()
    {
        $announcements = $this->searchContracts();

        return view('livewire.clients.announcements', [
            'announcements' => $announcements,
        ])->with("search");
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchContracts()
    {
        $query = $this->getQuery()->where('show_to_clients', true)->orderBy('created_at', 'desc');

        $query->where(function (Builder $query) {
            $this->filterResults();
        });

        $query->when(! empty($this->searchAnnouncement != ''), function (Builder $query) {
            $query->where('subject', 'like', '%'.$this->searchAnnouncement.'%');
            $query->orWhere('message', 'like', '%'.$this->searchAnnouncement.'%');
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
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     * @return mixed|string
     */
    function model()
    {
        return Announcement::class;
    }


    function searchableFields()
    {
        return [
            'subject',
            'message',
        ];
    }
}
