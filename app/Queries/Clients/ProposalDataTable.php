<?php

namespace App\Queries\Clients;

use App\Models\Customer;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProposalDataTable
 */
class ProposalDataTable
{
    /**
     *
     * @param  array  $input
     *
     * @return Proposal
     */
    public function get($input = [])
    {
        /** @var Proposal $query */
        $query = Proposal::whereOwnerType(Customer::class)->whereOwnerId(Auth::user()->contact->customer_id)->select('proposals.*')
            ->where('status', '!=', Proposal::STATUS_DRAFT);

        $query->when(isset($input['status']), function (Builder $q) use ($input) {
            $q->where('status', '=', $input['status']);
        });

        return $query;
    }
}
