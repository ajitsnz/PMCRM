<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Expenses extends SearchableComponent
{
    public $categoryFilter = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterCategory',
    ];

    /**
     * @return string
     */
    public function model()
    {
        return Expense::class;
    }

    /**
     * @return string[]
     */
    function searchableFields()
    {
        return ['name', 'expenseCategory.name'];
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $expenses = $this->searchExpenses();

        return view('livewire.expenses', compact('expenses'));
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchExpenses()
    {
        $this->setQuery($this->getQuery()->with('expenseCategory'));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when($this->categoryFilter !== '', function (Builder $q) {
            $q->where('expense_category_id', $this->categoryFilter);
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
    public function filterCategory($status)
    {
        $this->categoryFilter = $status;
        $this->searchExpenses();
    }
}
