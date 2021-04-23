<?php

namespace App\Queries\Clients;

use App\Models\Estimate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class EstimateDataTable
 */
class EstimateDataTable
{
    /**
     *
     * @param  array  $input
     *
     * @return mixed
     */
    public function get($input = [])
    {
        $query = Estimate::with('customer')->select('estimates.*')
            ->whereCustomerId(Auth::user()->contact->customer_id)->where('status', '!=', Estimate::STATUS_DRAFT);

        $query->when(isset($input['status']), function (Builder $q) use ($input) {
            $q->where('status', '=', $input['status']);
        });

        return $query;
    }
}
