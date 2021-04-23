<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Contact;
use App\Models\CustomerGroup;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Proposal;
use App\Models\Reminder;
use App\Models\Task;
use App\Queries\LeadDataTable;
use App\Repositories\LeadRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class LeadController extends AppBaseController
{
    /** @var  LeadRepository $leadRepository */
    private $leadRepository;

    public function __construct(LeadRepository $leadRepo)
    {
        $this->leadRepository = $leadRepo;
    }

    /**
     * Display a listing of the Lead.
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
            return DataTables::of((new LeadDataTable())->get($request->only(['status'])))->make(true);
        }

        $statusArr = LeadStatus::pluck('name', 'id');
        $data = $this->leadRepository->getLeadStatusCounts();

        return view('leads.index', compact('statusArr', 'data'));
    }

    /**
     * Show the form for creating a new Lead.
     *
     * @param  null  $customerId
     *
     * @return Factory|View
     */
    public function create($customerId = null)
    {
        $data = $this->leadRepository->getData();

        return view('leads.create', compact('data', 'customerId'));
    }

    /**
     * Store a newly created Lead in storage.
     *
     * @param  CreateLeadRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateLeadRequest $request)
    {
        $input = $request->all();

        $this->leadRepository->store($input);

        Flash::success('Lead saved successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Display the specified Lead.
     *
     * @param  Lead  $lead
     *
     * @return Factory|View
     */
    public function show(Lead $lead)
    {
        $groupName = (request('group') === null) ? 'lead_details' : (request('group'));

        $data = $this->leadRepository->getReminderData($lead->id, Lead::class);
        $notifiedReminder = Reminder::IS_NOTIFIED;
        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $notes = $this->leadRepository->getNoteData($lead);
        $data['languages'] = Lead::LANGUAGES; 
        $data['countries'] = Lead::COUNTRIES;
        $data['customerGroups'] = CustomerGroup::all()->pluck('name', 'id');
        $statusArr = Proposal::STATUS;

        return view("leads.views.$groupName",
            compact('lead', 'data', 'notifiedReminder', 'status', 'priorities', 'notes', 'groupName', 'statusArr'));
    }

    /**
     * Show the form for editing the specified Lead.
     *
     * @param  Lead  $lead
     *
     * @return Factory|View
     */
    public function edit(Lead $lead)
    {
        $data = $this->leadRepository->getData();

        return view('leads.edit', compact('lead', 'data'));
    }

    /**
     * Update the specified Lead in storage.
     *
     * @param  Lead  $lead
     *
     * @param  UpdateLeadRequest  $request
     *
     * @throws Exception
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Lead $lead, UpdateLeadRequest $request)
    {
        $input = $request->all();

        $this->leadRepository->update($input, $lead);

        Flash::success('Lead updated successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Remove the specified Lead from storage.
     *
     * @param  Lead  $lead
     *
     * @throws Exception
     *
     * @return JsonResource
     */
    public function destroy(Lead $lead)
    {
        $proposalLeadId = Proposal::where('owner_id', '=', $lead->id)->where('owner_type', '=',
            Lead::class)->exists();

        if ($proposalLeadId) {
            return $this->sendError('Lead can\'t be deleted.');
        }

        activity()->performedOn($lead)->causedBy(getLoggedInUser())
            ->useLog('Lead deleted.')->log($lead->name.' Lead deleted.');

        $this->leadRepository->delete($lead->id);

        return $this->sendSuccess('Lead deleted successfully.');
    }

    /**
     * @param  Lead  $lead
     *
     * @param  int  $status
     *
     * @return JsonResponse
     */
    public function changeStatus(Lead $lead, $status)
    {
        $lead->update(['status_id' => $status]);

        return $this->sendSuccess('Lead status updated successfully.');
    }

    /**
     * @return Factory|View
     */
    public function kanbanList()
    {
        /** @var Lead[] $leads */
        $leads = Lead::with(['assignedTo.media', 'leadSource'])->get()->groupBy('status_id');

        $leadStatus = LeadStatus::orderBy('order', 'asc')->get();

        return view('leads.kanban.index', compact('leads', 'leadStatus'));
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function contactAsPerCustomer(Request $request)
    {
        /** @var Contact $contact */
        $contact = Contact::with('user')->whereCustomerId($request->get('customer_id'))->get();
        $contacts = $contact->where('user.is_enable', '=', true)->pluck('user.full_name', 'id')->toArray();

        return $this->sendResponse($contacts, 'member retrieved data success.');
    }

    /**
     * @param  Lead  $lead
     *
     * @return mixed
     */
    public function getNotesCount(Lead $lead)
    {
        return $this->sendResponse($lead->notes()->count(), 'Notes count retrieved successfully.');
    }
}
