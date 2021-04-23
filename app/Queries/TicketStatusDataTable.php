<?php

namespace App\Queries;

use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TicketStatusDataTable
 * @package App\Queries
 */
class TicketStatusDataTable
{
    /**
     * @return TicketStatus|Builder
     */
    public function get()
    {
        /** @var TicketStatus $query */
        $query = TicketStatus::query()->select('ticket_statuses.*')->withCount('tickets');

        return $query;
    }
}
