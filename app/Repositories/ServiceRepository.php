<?php

namespace App\Repositories;

use App\Models\Service;

/**
 * Class ServiceRepository
 * @package App\Repositories
 * @version April 3, 2020, 12:35 pm UTC
 */
class ServiceRepository extends BaseRepository
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
        return Service::class;
    }
}
