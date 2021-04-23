<?php

namespace App\Repositories;

use App\Models\TicketStatus;

/**
 * Class TicketStatusRepository
 * @package App\Repositories
 * @version April 4, 2020, 3:50 am UTC
 */
class TicketStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pick_color',
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
        return TicketStatus::class;
    }
}
