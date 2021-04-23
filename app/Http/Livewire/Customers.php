<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class Customers extends SearchableComponent
{

    public $searchByCustomer = '';

    public $paginate = 15;

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return [
            'company_name',
        ];
    }

    /**
     *
     * @return string
     */
    function model()
    {
        return Customer::class;
    }

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $customers = $this->searchCustomer();

        return view('livewire.customers', compact('customers'))->with('searchByCustomer');
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchCustomer()
    {
        $query = $this->getQuery()->withCount(['contact', 'project', 'customerGroups']);

        $query->when(! empty($this->searchByCustomer != ''), function (Builder $query) {
            $query->Where('company_name', 'like', '%'.strtolower($this->searchByCustomer).'%');
        });

        return $this->paginate();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
