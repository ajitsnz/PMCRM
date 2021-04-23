<?php

namespace App\Http\Livewire\Clients;

use App\Http\Livewire\SearchableComponent;
use App\Models\Contract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Contracts extends SearchableComponent
{
    public $paginate = 9;

    public $statusFilter = '';

    public function render()
    {
        $contracts = $this->searchContracts();

        return view('livewire.clients.contracts', [
            'contracts' => $contracts,
        ])->with("search");
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchContracts()
    {
        $client_id = Auth::user()->contact->customer_id;

        $this->setQuery($this->getQuery()->with(['customer', 'type'])->where('customer_id', $client_id));

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('contract_type_id', $this->statusFilter);
        });

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        return $this->paginate();
    }

    /**
     *
     * @param  int  $Id
     */
    public function filterType($Id)
    {
        $this->statusFilter = $Id;

        $this->resetPage();
    }

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterType',
    ];

    /**
     * @return mixed|string
     */
    function model()
    {
        return Contract::class;
    }

    /**
     * @return mixed|string[]
     */
    function searchableFields()
    {
        return [
            'subject',
            'contract_value',
            'customer.company_name',
            'type.name',
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
