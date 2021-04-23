<?php

namespace App\Http\Livewire\Clients;

use App\Http\Livewire\SearchableComponent;
use App\Models\Invoice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Invoices extends SearchableComponent
{
    public $paginate = 9;

    public $statusFilter = '';

    public function render()
    {
        $invoices = $this->searchInvoices();

        return view('livewire.clients.invoices', [
            'invoices' => $invoices,
        ])->with("search");
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchInvoices()
    {
        $client_id = Auth::user()->contact->customer_id;

        $this->setQuery($this->getQuery()->with('customer')->where('customer_id', $client_id)->where('payment_status',
            '!=', Invoice::STATUS_DRAFT));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('payment_status', $this->statusFilter);
        });

        return $this->paginate();
    }

    function filterPaymentStatus($id)
    {
        $this->statusFilter = $id;
    }

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterPaymentStatus',
    ];

    /**
     * @return mixed|string
     */
    function model()
    {
        return Invoice::class;
    }

    /**
     * @return mixed|string[]
     */
    function searchableFields()
    {
        return [
            'title',
            'invoice_number',
            'customer.company_name',
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
