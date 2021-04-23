<?php

namespace App\Repositories;

use App\Models\ExpenseCategory;

/**
 * Class ExpenseCategoryRepository
 * @package App\Repositories
 * @version April 3, 2020, 9:11 am UTC
 */
class ExpenseCategoryRepository extends BaseRepository
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
        return ExpenseCategory::class;
    }
}
