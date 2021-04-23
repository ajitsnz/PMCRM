<?php

namespace App\Queries;

use App\Models\Department;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class DepartmentDataTable
{
    /**
     *
     * @return Department
     */
    public function get()
    {
        /** @var Department $query */
        $query = Department::query()->select('departments.*');

        return $query;
    }
}
