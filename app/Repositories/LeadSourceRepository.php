<?php

namespace App\Repositories;

use App\Models\LeadSource;

/**
 * Class LeadSourceRepository
 * @package App\Repositories
 * @version April 6, 2020, 5:43 am UTC
 */
class LeadSourceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return LeadSource::class;
    }
}
