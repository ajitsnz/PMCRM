<?php

namespace App\Queries\Clients;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class InvoiceDataTable
 */
class InvoiceDataTable
{
    /**
     *
     * @param  array  $input
     *
     * @return Invoice
     */
    public function get($input = [])
    {
        $clientCustomerId = Auth::user()->contact->customer_id;

        /** @var Invoice $query */
        $query = Invoice::with('customer')->select('invoices.*')->whereCustomerId($clientCustomerId)->where('payment_status',
            '!=', Invoice::STATUS_DRAFT);

        $query->when(isset($input['payment_status']), function (Builder $q) use ($input) {
            $q->where('payment_status', '=', $input['payment_status']);
        });

        return $query;
    }
}
