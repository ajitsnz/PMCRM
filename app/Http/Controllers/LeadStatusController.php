<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadStatusRequest;
use App\Http\Requests\UpdateLeadStatusRequest;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Queries\LeadStatusDataTable;
use App\Repositories\LeadStatusRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class LeadStatusController extends AppBaseController
{
    /** @var  LeadStatusRepository */
    private $leadStatusRepository;

    public function __construct(LeadStatusRepository $leadStatusRepo)
    {
        $this->leadStatusRepository = $leadStatusRepo;
    }

    /**
     * Display a listing of the LeadStatus.
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
            return DataTables::of((new LeadStatusDataTable())->get())->make(true);
        }

        return view('lead_statuses.index');
    }

    /**
     * Store a newly created LeadStatus in storage.
     *
     * @param  CreateLeadStatusRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeadStatusRequest $request)
    {
        $input = $request->all();
        $leadStatus = $this->leadStatusRepository->create($input);

        activity()->performedOn($leadStatus)->causedBy(getLoggedInUser())
            ->useLog('New Lead Status created.')->log($leadStatus->name.' Lead Status created.');

        return $this->sendSuccess('Lead Status saved successfully.');
    }

    /**
     * Show the form for editing the specified LeadStatus.
     *
     * @param  LeadStatus  $leadStatus
     *
     * @return JsonResponse
     */
    public function edit(LeadStatus $leadStatus)
    {
        return $this->sendResponse($leadStatus, 'Lead Status retrieved successfully.');
    }

    /**
     * Update the specified LeadStatus in storage.
     *
     * @param  UpdateLeadStatusRequest  $request
     *
     * @param  LeadStatus  $leadStatus
     *
     * @return JsonResponse
     */
    public function update(UpdateLeadStatusRequest $request, LeadStatus $leadStatus)
    {
        $input = $request->all();
        $leadStatus = $this->leadStatusRepository->update($input, $leadStatus->id);
        activity()->performedOn($leadStatus)->causedBy(getLoggedInUser())
            ->useLog('Lead Status updated.')->log($leadStatus->name.' Lead Status updated.');

        return $this->sendSuccess('Lead Status updated successfully.');
    }

    /**
     * Remove the specified LeadStatus from storage.
     *
     * @param  LeadStatus  $leadStatus
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(LeadStatus $leadStatus)
    {
        $leadStatusId = Lead::where('status_id', '=', $leadStatus->id)->exists();

        if ($leadStatusId) {
            return $this->sendError('Lead Status used somewhere else.');
        }

        activity()->performedOn($leadStatus)->causedBy(getLoggedInUser())
            ->useLog('Lead Status deleted.')->log($leadStatus->name.' Lead Status deleted.');

        $leadStatus->delete();

        return $this->sendSuccess('Lead Status deleted successfully.');
    }
}
