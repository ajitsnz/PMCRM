<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketStatusRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Queries\TicketStatusDataTable;
use App\Repositories\TicketStatusRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TicketStatusController extends AppBaseController
{
    /** @var  TicketStatusRepository */
    private $ticketStatusRepository;

    public function __construct(TicketStatusRepository $ticketStatusRepo)
    {
        $this->ticketStatusRepository = $ticketStatusRepo;
    }

    /**
     * Display a listing of the TicketStatus.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new TicketStatusDataTable())->get())->make(true);
        }

        return view('ticket_statuses.index');
    }

    /**
     * Store a newly created TicketStatus in storage.
     *
     * @param  CreateTicketStatusRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateTicketStatusRequest $request)
    {
        $input = $request->all();
        $ticketStatus = $this->ticketStatusRepository->create($input);
        activity()->performedOn($ticketStatus)->causedBy(getLoggedInUser())
            ->useLog('New Ticket Status created.')->log($ticketStatus->name.' Ticket Status created.');

        return $this->sendSuccess('Ticket Status saved successfully.');
    }

    /**
     * Show the form for editing the specified TicketStatus.
     *
     * @param  TicketStatus  $ticketStatus
     *
     * @return JsonResponse
     */
    public function edit(TicketStatus $ticketStatus)
    {
        return $this->sendResponse($ticketStatus, 'Ticket Status retrieved successfully.');
    }

    /**
     * Update the specified TicketStatus in storage.
     *
     * @param  UpdateTicketStatusRequest  $request
     *
     * @param  TicketStatus  $ticketStatus
     *
     * @return JsonResponse
     */
    public function update(UpdateTicketStatusRequest $request, TicketStatus $ticketStatus)
    {
        $input = $request->all();
        $ticketStatus = $this->ticketStatusRepository->update($input, $ticketStatus->id);
        activity()->performedOn($ticketStatus)->causedBy(getLoggedInUser())
            ->useLog('Ticket Status updated.')->log($ticketStatus->name.' Ticket Status updated.');

        return $this->sendSuccess('Ticket Status updated successfully.');
    }

    /**
     * Remove the specified TicketStatus from storage.
     *
     * @param  TicketStatus  $ticketStatus
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(TicketStatus $ticketStatus)
    {
        $ticketStatusId = Ticket::where('ticket_status_id', '=', $ticketStatus->id)->exists();

        if ($ticketStatusId) {
            return $this->sendError('Ticket Status used somewhere else.');
        }

        activity()->performedOn($ticketStatus)->causedBy(getLoggedInUser())
            ->useLog('Ticket Status deleted.')->log($ticketStatus->name.' Ticket Status deleted.');

        $ticketStatus->delete();

        return $this->sendSuccess('Ticket Status deleted successfully.');
    }

}
