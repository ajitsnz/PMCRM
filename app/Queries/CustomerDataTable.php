<?php

namespace App\Queries;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CustomerDataTable
 */
class CustomerDataTable
{
    /**
     * @return Customer|Builder
     */
    public function get()
    {
        /** @var Customer $query */
        $query = Customer::with('customerGroups')->select('customers.*');

        return $query;
    }
}
