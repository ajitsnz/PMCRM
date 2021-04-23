<?php

namespace App\Queries;

use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ContractDataTable
 * @package App\Queries
 */
class ContractDataTable
{
    /**
     * @param  array  $input
     *
     * @return Contract|Builder
     */
    public function get($input = [])
    {
        /** @var Contract $query */
        $query = Contract::with(['type', 'customer'])->select('contracts.*');

        $query->when(isset($input['type']) && $input['type'] != ContractType::pluck('name', 'id'),
            function (Builder $q) use ($input) {
                $q->where('contract_type_id', '=', $input['type']);
            });

        return $query;
    }
}
