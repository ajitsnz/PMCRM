<?php

namespace App\Queries;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PaymentDataTable
 */
class PaymentDataTable
{
    /**
     * @param  array  $input
     *
     * @return Payment
     */
    public function get($input = [])
    {
        /** @var Payment $query */
        $query = Payment::with('paymentMode')->select('payments.*');

        $query->when(isset($input['owner_id']), function (Builder $q) use ($input) {
            $q->where('owner_id', '=', $input['owner_id']);
        });

        $query->when(isset($input['owner_type']), function (Builder $q) use ($input) {
            $q->where('owner_type', '=', $input['owner_type']);
        });

        return $query;
    }
}
