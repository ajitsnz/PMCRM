<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;

class Services extends SearchableComponent
{
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
        return Service::class;
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
        $services = $this->searchServices();

        return view('livewire.services', compact('services'));
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchServices()
    {
        $this->getQuery();

        return $this->paginate();
    }
}
