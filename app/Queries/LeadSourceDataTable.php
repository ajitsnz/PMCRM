<?php

namespace App\Queries;

use App\Models\LeadSource;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LeadSourceDataTable
 * @package App\Queries
 */
class LeadSourceDataTable
{
    /**
     * @return LeadSource|Builder
     */
    public function get()
    {
        /** @var LeadSource $query */
        $query = LeadSource::select('lead_sources.*')->withCount('usedLeadSource');

        return $query;
    }
}
