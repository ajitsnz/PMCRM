<?php

namespace App\Queries;

use App\Models\LeadStatus;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LeadStatusDataTable
 * @package App\Queries
 */
class LeadStatusDataTable
{
    /**
     * @return LeadStatus|Builder
     */
    public function get()
    {
        /** @var LeadStatus $query */
        $query = LeadStatus::query()->select('lead_statuses.*')->withCount('leads');

        return $query;
    }
}
