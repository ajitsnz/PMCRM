<?php

namespace App\Queries;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GoalDataTable
 * @package App\Queries
 */
class GoalDataTable
{
    /**
     * @param  array  $input
     *
     * @return Goal|Builder
     */
    public function get($input = [])
    {
        /** @var Goal $query */
        $query = Goal::with(['goalMembers'])->select('goals.*');

        $query->when(isset($input['goal_type']), function (Builder $q) use ($input) {
            $q->where('goal_type', '=', $input['goal_type']);
        });

        return $query;
    }
}
