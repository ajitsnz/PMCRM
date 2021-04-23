<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class Departments extends SearchableComponent
{
    public $searchByDepartment = '';
    public $paginate = 15;

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     *
     * @return string
     */
    public function model()
    {
        return Department::class;
    }

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return ['name'];
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $departments = $this->searchDepartments();

        return view('livewire.departments', compact('departments'));
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchDepartments()
    {
        $this->getQuery()->when(! empty($this->searchByDepartment != ''), function (Builder $query) {
            $query->where('name', 'like', '%'.strtolower($this->searchByDepartment).'%');
        });

        return $this->paginate();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
