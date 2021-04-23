<?php

namespace App\Queries;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProjectDataTable
 */
class ProjectDataTable
{
    /**
     * @param  array  $input
     *
     * @return Project
     */
    public function get($input = [])
    {
        /** @var Project $query */
        $query = Project::with('customer')->select('projects.*');

        $query->when(isset($input['status']),
            function (Builder $q) use ($input) {
                $q->where('status', '=', $input['status']);
            });

        $query->when(isset($input['customer_id']),
            function (Builder $q) use ($input) {
                $q->where('customer_id', '=', $input['customer_id']);
            });

        return $query;
    }
}
