<?php

namespace App\Queries;

use App\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CustomerGroupDataTable
 * @package App\Queries
 */
class CustomerGroupDataTable
{
    /**
     * @return CustomerGroup|Builder
     */
    public function get()
    {
        /** @var CustomerGroup $query */
        return CustomerGroup::withCount('customers');
    }
}
