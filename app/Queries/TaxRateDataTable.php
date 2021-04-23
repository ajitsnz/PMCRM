<?php

namespace App\Queries;

use App\Models\TaxRate;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class TaxRateDataTable
{
    /**
     * @return TaxRate|Builder
     */
    public function get()
    {
        /** @var TaxRate $query */
        $query = TaxRate::query()->select('tax_rates.*');

        return $query;
    }
}
