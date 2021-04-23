<?php

namespace App\Http\Livewire;

use App\Models\TaxRate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class TaxRates extends SearchableComponent
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'deleteTaxRate',
    ];

    /**
     * @return string
     */
    public function model()
    {
        return TaxRate::class;
    }

    /**
     * @return string[]
     */
    function searchableFields()
    {
        return ['name', 'tax_rate'];
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $taxRates = $this->searchTaxRates();

        return view('livewire.tax-rates', compact('taxRates'));
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchTaxRates()
    {
        $this->getQuery();

        return $this->paginate();
    }

    /**
     * @param $taxRateId
     */
    public function deleteTaxRate($taxRateId)
    {
        $taxRate = TaxRate::find($taxRateId);
        activity()->performedOn($taxRate)->causedBy(getLoggedInUser())
            ->useLog('Tax Rate deleted.')->log($taxRate->name.' Tax Rate deleted.');
        
        $taxRate->delete();
        $this->dispatchBrowserEvent('deleted');
        $this->searchTaxRates();
    }
}
