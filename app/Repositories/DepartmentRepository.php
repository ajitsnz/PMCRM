<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Support\Collection;

/**
 * Class DepartmentRepository
 * @package App\Repositories
 * @version April 3, 2020, 11:57 am UTC
 */
class DepartmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'hide_from_clients',
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
        return Department::class;
    }

    /**
     * get Departments.
     *
     * @return Collection
     */
    public function getDepartmentsList()
    {
        return Department::orderBy('name', 'asc')->pluck('name', 'id');
    }
}
