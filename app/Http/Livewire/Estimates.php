<?php

namespace App\Http\Livewire;


use App\Models\Estimate;
use App\Repositories\EstimateRepository;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Estimates extends SearchableComponent
{
    public $statusFilter = '';
    public $customer = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterEstimateStatus',
    ];

    /**
     *
     * @return string
     */
    public function model()
    {
        return Estimate::class;
    }

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return [
            'title',
            'estimate_number',
            'customer.company_name',
        ];
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $estimates = $this->searchEstimates();
        $estimatesRepo = app(EstimateRepository::class);
        $statusCount = $estimatesRepo->getEstimatesStatusCount();
        $customer = $this->customer;
        $estimateStatus = Estimate::STATUS;

        return view('livewire.estimates', compact('estimates', 'statusCount', 'customer', 'estimateStatus'));
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchEstimates()
    {
        $this->setQuery($this->getQuery()->with('customer'));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->statusFilter !== '', function (Builder $q) {
            $q->where('status', $this->statusFilter);
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
     *
     */
    public function filterEstimateStatus($id)
    {
        $this->statusFilter = $id;
    }
}
