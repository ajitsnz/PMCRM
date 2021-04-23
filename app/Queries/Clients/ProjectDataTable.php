<?php

namespace App\Queries\Clients;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectDataTable
 */
class ProjectDataTable
{
    /**
     * @param  array  $input
     *
     * @return mixed
     */
    public function get($input = [])
    {
        $query = Project::with('customer')->whereHas('projectContacts', function (Builder $query) {
            $query->where('contact_id', '=', Auth::user()->owner_id);
        });

        $query->when(isset($input['status']),
            function (Builder $q) use ($input) {
                $q->where('status', '=', $input['status']);
            });

        return $query->select('projects.*');
    }
}
