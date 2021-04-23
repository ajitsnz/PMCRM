<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Customer;
use Illuminate\Support\Collection;

/**
 * Class ContractRepository
 * @package App\Repositories
 * @version April 21, 2020, 8:30 am UTC
 */
class ContractRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
        'customer_id',
        'contract_type_id',
        'description',
        'start_time',
        'end_date',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Contract::class;
    }

    /**
     * @return Collection
     */
    public function getContractType()
    {
        /** @var ContractType $contractType */
        return ContractType::get()->pluck('name', 'id');
    }

    /**
     * @return Collection
     */
    public function getCustomer()
    {
        /** @var Customer $customer */
        return Customer::get()->pluck('company_name', 'id');
    }
}
