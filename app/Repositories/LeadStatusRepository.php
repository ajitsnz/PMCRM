<?php

namespace App\Repositories;

use App\Models\LeadStatus;

/**
 * Class LeadStatusRepository
 * @package App\Repositories
 * @version April 6, 2020, 4:03 am UTC
 */
class LeadStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'color',
        'order',
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
        return LeadStatus::class;
    }
}
