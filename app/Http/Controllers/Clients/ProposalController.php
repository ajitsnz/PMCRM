<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Proposal;
use App\Models\Setting;
use App\Queries\Clients\ProposalDataTable;
use App\Repositories\ProposalRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class ProposalController
 */
class ProposalController extends AppBaseController
{
    /**
     * @var ProposalRepository
     */
    private $proposalRepository;

    function __construct(ProposalRepository $proposalRepository)
    {
        $this->proposalRepository = $proposalRepository;
    }

    /**
     * Display a listing of the Proposal.
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
            return DataTables::of((new ProposalDataTable())->get($request->only(['status'])))->make(true);
        }

        $proposalStatusCount = $this->proposalRepository->getProposalsStatusCount(getLoggedInUser()->contact->customer_id);
        $proposalStatus = Proposal::CLIENT_STATUS;

        return view('clients.proposals.index', compact('proposalStatusCount', 'proposalStatus'));
    }

    /**
     * @param  Proposal  $proposal
     *
     * @return Factory|View
     */
    public function viewAsCustomer(Proposal $proposal)
    {
        $proposal = $this->proposalRepository->getSyncListForProposalDetail($proposal->id);
        $totalPaid = 0;
        $proposalStatus = Proposal::STATUS;

        return view('clients.proposals.view_as_customer', compact('proposal', 'totalPaid', 'proposalStatus'));
    }

    /**
     * @param  Proposal  $proposal
     *
     * @return mixed
     */
    public function covertToPdf(Proposal $proposal)
    {
        $proposal = $this->proposalRepository->getSyncListForProposalDetail($proposal->id);

        $totalPaid = 0;

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $pdf = PDF::loadView('clients.proposals.proposal_pdf', compact(['proposal', 'settings', 'totalPaid']));

        return $pdf->download(__('messages.proposal.proposal_prefix').$proposal->proposal_number.'.pdf');
    }

    /**
     * @param  Proposal  $proposal
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function changeStatus(Proposal $proposal, Request $request)
    {
        $status = $request->status;
        $changeStatus = $this->proposalRepository->changeProposalStatus($proposal->id, $status);

        return redirect()->route('clients.proposals.view-as-customer', $proposal->id);
    }
}
