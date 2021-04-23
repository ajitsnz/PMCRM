<?php

namespace App\Repositories;

use App\Models\TicketPriority;

/**
 * Class TicketPriorityRepository
 * @package App\Repositories
 * @version April 3, 2020, 8:00 am UTC
 */
class TicketPriorityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status',
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
        return TicketPriority::class;
    }
}
