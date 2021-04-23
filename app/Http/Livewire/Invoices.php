<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Invoices extends SearchableComponent
{
    public $statusFilter = '';
    public $customer = '';

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
     * @return Application|Factory|View
     */
    public function render()
    {
        $invoices = $this->searchInvoices();
        $invoiceRepo = app(InvoiceRepository::class);
        $statusCount = $invoiceRepo->getInvoicesStatusCount();
        $customer = $this->customer;
        $invoiceStatus = Invoice::PAYMENT_STATUS;

        return view('livewire.invoices', compact('invoices', 'statusCount', 'customer', 'invoiceStatus'));
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchInvoices()
    {
        $this->setQuery($this->getQuery()->with('customer'));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('payment_status', $this->statusFilter);
        });

        $this->getQuery()->when($this->customer !== '', function (Builder $q) {
            $q->where('customer_id', $this->customer);
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
        $this->resetPage();
    }
}
