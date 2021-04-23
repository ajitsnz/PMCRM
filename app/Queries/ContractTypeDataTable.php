<?php

namespace App\Queries;

use App\Models\ContractType;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class ContractTypeDataTable
{
    /**
     * @return ContractType
     */
    public function get()
    {
        /** @var ContractType $query */
        $query = ContractType::query()->select('contract_types.*')->withCount('contracts');

        return $query;
    }
}
