<?php

namespace App\Queries;

use App\Models\Proposal;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProposalDataTable
 * @package App\Queries
 */
class ProposalDataTable
{
    /**
     * @param  array  $input
     *
     * @return Proposal
     */
    public function get($input = [])
    {
        /** @var Proposal $query */
        $query = Proposal::with('user')->select('proposals.*');

        $query->when(isset($input['status']) && $input['status'] != Proposal::STATUS,
            function (Builder $q) use ($input) {
                $q->where('status', '=', $input['status']);
            });

        $query->when($input['owner_id'] != null, function (Builder $q) use ($input) {
            $q->where('owner_id', '=', $input['owner_id'])
                ->where('owner_type', '=', $input['owner_type']);
        });

        return $query;
    }
}
