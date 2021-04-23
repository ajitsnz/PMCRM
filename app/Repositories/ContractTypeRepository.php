<?php

namespace App\Repositories;

use App\Models\ContractType;

/**
 * Class ContractTypeRepository
 * @package App\Repositories
 * @version April 8, 2020, 4:20 am UTC
*/

class ContractTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
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
        return ContractType::class;
    }
}
