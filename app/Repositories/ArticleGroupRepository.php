<?php

namespace App\Repositories;

use App\Models\ArticleGroup;

/**
 * Class ArticleGroupRepository
 * @package App\Repositories
 * @version April 3, 2020, 4:25 am UTC
 */
class ArticleGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'group_name',
        'color',
        'description',
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
        return ArticleGroup::class;
    }
}
