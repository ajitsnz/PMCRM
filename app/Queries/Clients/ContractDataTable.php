<?php

namespace App\Queries\Clients;

use App\Models\Contract;
use Illuminate\Support\Facades\Auth;

/**
 * Class ContractDataTable
 */
class ContractDataTable
{
    /**
     *
     * @return Contract
     */
    public function get()
    {
        $clientCustomerId = Auth::user()->contact->customer_id;

        /** @var Contract $query */
        $query = Contract::with(['customer', 'type'])->select('contracts.*')->whereCustomerId($clientCustomerId);

        return $query;
    }
}
