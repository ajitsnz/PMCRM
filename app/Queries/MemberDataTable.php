<?php

namespace App\Queries;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MemberDataTable
 * @package App\Queries
 */
class MemberDataTable
{
    /**
     * @param  array  $input
     *
     * @return User|Builder
     */
    public function get($input = [])
    {
        /** @var User $query */
        $query = User::user()->select('users.*');

        $query->when(isset($input['is_enable']) && $input['is_enable'] != User::STATUS_ALL,
            function (Builder $q) use ($input) {
                $q->where('is_enable', '=', $input['is_enable']);
            });

        return $query;
    }
}
