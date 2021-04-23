<?php

namespace App\Repositories;

use App\Models\CustomerGroup;

/**
 * Class CustomerGroupRepository
 */
class CustomerGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
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
        return CustomerGroup::class;
    }
}
