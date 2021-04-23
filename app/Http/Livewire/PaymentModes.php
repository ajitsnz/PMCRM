<?php

namespace App\Http\Livewire;


use App\Models\PaymentMode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentModes extends SearchableComponent
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
     * @return string
     */
    public function model()
    {
        return PaymentMode::class;
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
        $paymentModes = $this->searchPaymentModes();

        return view('livewire.payment-modes', compact('paymentModes'));
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchPaymentModes()
    {
        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('active', $this->statusFilter);
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
     * @param $status
     */
    public function filterStatus($status)
    {
        $this->statusFilter = $status;
        $this->searchPaymentModes();
    }
}
