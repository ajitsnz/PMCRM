<?php

namespace App\Http\Livewire;


use App\Models\Contract;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Contracts extends SearchableComponent
{
    public $paginate = 9;

    public $filterContractType = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterType',
    ];

    public function model()
    {
        return Contract::class;
    }

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return [
            'subject',
            'customer.company_name',
            'type.name',
        ];
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $contracts = $this->searchContracts();

        return view('livewire.contracts', compact('contracts'));
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchContracts()
    {
        $this->setQuery($this->getQuery()->with(['customer', 'type']));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->filterContractType !== '', function (Builder $q) {
            $q->where('contract_type_id', $this->filterContractType);
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
     *
     * @param  int  $Id
     */
    public function filterType($Id)
    {
        $this->filterContractType = $Id;
        $this->resetPage();
    }
}
