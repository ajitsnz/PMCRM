<?php

namespace App\Queries;

use App\Models\CreditNote;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class CreditNoteDataTable
{
    /**
     * @param  array  $input
     *
     * @return CreditNote
     */
    public function get($input = [])
    {
        /** @var CreditNote $query */
        $query = CreditNote::with('customer')->select('credit_notes.*');

        $query->when($input['customer_id'] != null, function (Builder $q) use ($input) {
            $q->where('customer_id', '=', $input['customer_id']);
        });

        $query->when(isset($input['payment_status']) && ($input['payment_status'] != null || $input['payment_status'] == 0),
            function (Builder $q) use ($input) {
                $q->where('payment_status', '=', $input['payment_status']);
            });

        return $query;
    }
}
