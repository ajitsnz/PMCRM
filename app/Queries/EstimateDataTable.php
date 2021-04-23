<?php

namespace App\Queries;

use App\Models\Estimate;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EstimateDataTable
 */
class EstimateDataTable
{
    /**
     * @param  array  $input
     *
     * @return Estimate
     */
    public function get($input = [])
    {
        /** @var Estimate $query */
        $query = Estimate::with('customer')->select('estimates.*');

        $query->when($input['customer_id'] != null, function (Builder $q) use ($input) {
            $q->where('customer_id', '=', $input['customer_id']);
        });

        $query->when(isset($input['status']) && $input['status'] != Estimate::STATUS,
            function (Builder $q) use ($input) {
                $q->where('status', '=', $input['status']);
            });

        return $query;
    }
}
