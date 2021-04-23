<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadSourceRequest;
use App\Http\Requests\UpdateLeadSourceRequest;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Queries\LeadSourceDataTable;
use App\Repositories\LeadSourceRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class LeadSourceController extends AppBaseController
{
    /** @var  LeadSourceRepository */
    private $leadSourceRepository;

    public function __construct(LeadSourceRepository $leadSourceRepo)
    {
        $this->leadSourceRepository = $leadSourceRepo;
    }

    /**
     * Display a listing of the LeadSource.
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
            return DataTables::of((new LeadSourceDataTable())->get())->make(true);
        }

        return view('lead_sources.index');
    }

    /**
     * Store a newly created LeadSource in storage.
     *
     * @param  CreateLeadSourceRequest  $request
     *
     * @return JsonResource
     */
    public function store(CreateLeadSourceRequest $request)
    {
        $input = $request->all();
        $leadSource = $this->leadSourceRepository->create($input);
        activity()->performedOn($leadSource)->causedBy(getLoggedInUser())
            ->useLog('New Lead Source created.')->log($leadSource->name.' Lead Source created.');

        return $this->sendSuccess('Lead Source saved successfully.');
    }

    /**
     * Show the form for editing the specified LeadSource.
     *
     * @param  LeadSource  $leadSource
     *
     * @return JsonResource
     */
    public function edit(LeadSource $leadSource)
    {
        return $this->sendResponse($leadSource, 'Lead Source retrieved successfully.');
    }

    /**
     * Update the specified LeadSource in storage.
     *
     * @param  UpdateLeadSourceRequest  $request
     *
     * @param  LeadSource  $leadSource
     *
     * @return JsonResource
     */
    public function update(UpdateLeadSourceRequest $request, LeadSource $leadSource)
    {
        $input = $request->all();
        $leadSource = $this->leadSourceRepository->update($input, $leadSource->id);
        activity()->performedOn($leadSource)->causedBy(getLoggedInUser())
            ->useLog('Lead Source updated.')->log($leadSource->name.' Lead Source updated.');

        return $this->sendSuccess('Lead Source updated successfully.');
    }

    /**
     * Remove the specified LeadSource from storage.
     *
     * @param  LeadSource  $leadSource
     *
     * @throws Exception
     *
     * @return JsonResource
     */
    public function destroy(LeadSource $leadSource)
    {
        $leadSourceId = Lead::where('source_id', '=', $leadSource->id)->exists();

        if ($leadSourceId) {
            return $this->sendError('Lead Source used somewhere else.');
        }

        activity()->performedOn($leadSource)->causedBy(getLoggedInUser())
            ->useLog('Lead Source deleted.')->log($leadSource->name.' Lead Source deleted.');

        $leadSource->delete();

        return $this->sendSuccess('Lead Source deleted successfully.');
    }
}
