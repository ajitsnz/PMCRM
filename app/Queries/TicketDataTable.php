<?php

namespace App\Queries;

use App\Models\Ticket;
use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TicketDataTable
 */
class TicketDataTable
{
    /**
     * @param  array  $input
     *
     * @return Ticket|Builder
     */
    public function get($input = [])
    {
        /** @var Ticket $query */
        $query = Ticket::with(['service', 'ticketPriority', 'ticketStatus'])->select('tickets.*');

        $query->when(isset($input['status']) && $input['status'] != TicketPriority::pluck('name', 'id'),
            function (Builder $q) use ($input) {
                $q->where('ticket_status_id', '=', $input['status']);
            });

        $query->when(isset($input['customer_id']), function (Builder $q) use ($input) {
            $q->whereHas('contact', function (Builder $q) use ($input) {
                $q->where('customer_id', '=', $input['customer_id']);
            });
        });

        return $query;
    }
}
