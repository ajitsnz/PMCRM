<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketPriorityRequest;
use App\Http\Requests\UpdateTicketPriorityRequest;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Queries\TicketPriorityDataTable;
use App\Repositories\TicketPriorityRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TicketPriorityController extends AppBaseController
{
    /** @var  TicketPriorityRepository */
    private $ticketPriorityRepository;

    public function __construct(TicketPriorityRepository $ticketPriorityRepo)
    {
        $this->ticketPriorityRepository = $ticketPriorityRepo;
    }

    /**
     * Display a listing of the TicketPriority.
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
            return DataTables::of((new TicketPriorityDataTable())->get($request->only(['status'])))->make(true);
        }

        $statusArr = TicketPriority::STATUS_ARR;

        return view('ticket_priorities.index', compact('statusArr'));
    }

    /**
     * Store a newly created TicketPriority in storage.
     *
     * @param  CreateTicketPriorityRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateTicketPriorityRequest $request)
    {
        $input = $request->all();
        $input['status'] = ! isset($input['status']) ? false : true;
        $ticketPriority = $this->ticketPriorityRepository->create($input);
        activity()->performedOn($ticketPriority)->causedBy(getLoggedInUser())
            ->useLog('New Ticket Priority created.')->log($ticketPriority->name.' Ticket Priority created.');

        return $this->sendSuccess('Ticket Priority saved successfully.');
    }

    /**
     * Show the form for editing the specified TicketPriority.
     *
     * @param  TicketPriority  $ticketPriority
     *
     * @return JsonResponse
     */
    public function edit(TicketPriority $ticketPriority)
    {
        return $this->sendResponse($ticketPriority, 'Ticket Priority retrieved successfully.');
    }

    /**
     * Update the specified TicketPriority in storage.
     *
     * @param  UpdateTicketPriorityRequest  $request
     *
     * @param  TicketPriority  $ticketPriority
     *
     * @return JsonResponse
     */
    public function update(UpdateTicketPriorityRequest $request, TicketPriority $ticketPriority)
    {
        $input = $request->all();
        $input['status'] = ! isset($input['status']) ? false : true;
        $ticketPriority = $this->ticketPriorityRepository->update($input, $ticketPriority->id);
        activity()->performedOn($ticketPriority)->causedBy(getLoggedInUser())
            ->useLog('Ticket Priority updated.')->log($ticketPriority->name.' Ticket Priority updated.');

        return $this->sendSuccess('Ticket Priority updated successfully.');
    }

    /**
     * Remove the specified TicketPriority from storage.
     *
     * @param  TicketPriority  $ticketPriority
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(TicketPriority $ticketPriority)
    {
        $ticketPriorityId = Ticket::where('priority_id', '=', $ticketPriority->id)->exists();

        if ($ticketPriorityId) {
            return $this->sendError('Ticket Priority used somewhere else.');
        }

        activity()->performedOn($ticketPriority)->causedBy(getLoggedInUser())
            ->useLog('Ticket Priority deleted.')->log($ticketPriority->name.' Ticket Priority deleted.');

        $ticketPriority->delete();

        return $this->sendSuccess('Ticket Priority deleted successfully.');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeActiveCategory($id)
    {
        $ticketPriority = TicketPriority::findOrFail($id);
        $ticketPriority->status = ! $ticketPriority->status;
        $ticketPriority->save();

        return $this->sendSuccess('Status updated successfully.');
    }
}
