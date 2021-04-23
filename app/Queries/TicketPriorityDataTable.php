<?php

namespace App\Queries;

use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TicketPriorityDataTable
 * @package App\Queries
 */
class TicketPriorityDataTable
{
    /**
     * @param  array  $input
     *
     * @return TicketPriority|Builder
     */
    public function get($input = [])
    {
        /** @var TicketPriority $query */
        $query = TicketPriority::query()->select('ticket_priorities.*')->withCount('tickets');

        $query->when(isset($input['status']) && $input['status'] != TicketPriority::STATUS_ALL,
            function (Builder $q) use ($input) {
                $q->where('status', '=', $input['status']);
            });

        return $query;
    }
}
