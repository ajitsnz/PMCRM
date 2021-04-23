<?php

namespace App\Queries;

use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LeadDataTable
 */
class LeadDataTable
{
    /**
     * @param  array  $input
     *
     * @return Lead|Builder
     */
    public function get($input = [])
    {
        /** @var Lead $query */
        $query = Lead::with([
            'leadSource', 'leadStatus', 'assignedTo', 'tags',
        ])->select('leads.*');

        $query->when(isset($input['status']) && $input['status'] != LeadStatus::pluck('name', 'id'),
            function (Builder $q) use ($input) {
                $q->where('status_id', '=', $input['status']);
            });

        return $query;
    }
}
