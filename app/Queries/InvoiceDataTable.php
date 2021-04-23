<?php

namespace App\Queries;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class InvoiceDataTable
{
    /**
     * @param  array  $input
     *
     * @return Invoice
     */
    public function get($input = [])
    {
        /** @var Invoice $query */
        $query = Invoice::with('customer')->select('invoices.*');

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
