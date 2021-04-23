<?php

namespace App\Repositories;

use App\Models\ItemGroup;

/**
 * Class ItemGroupRepository
 * @package App\Repositories
 * @version April 6, 2020, 5:56 am UTC
*/

class ItemGroupRepository extends BaseRepository
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
        return ItemGroup::class;
    }
}
