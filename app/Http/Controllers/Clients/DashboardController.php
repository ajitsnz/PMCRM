<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Repositories\EstimateRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProposalRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class DashboardController
 */
class DashboardController extends AppBaseController
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;
    /**
     * @var ProposalRepository
     */
    private $proposalRepository;
    /**
     * @var EstimateRepository
     */
    private $estimateRepository;

    function __construct(
        ProjectRepository $projectRepository,
        InvoiceRepository $invoiceRepository,
        ProposalRepository $proposalRepository,
        EstimateRepository $estimateRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->proposalRepository = $proposalRepository;
        $this->estimateRepository = $estimateRepository;
    }

    /**
     *
     * @return Factory|View
     */
    public function index()
    {
        $data['projectStatusCount'] = $this->projectRepository->getProjectsStatusCount(getLoggedInUser()->contact->customer_id);
        $data['estimateStatusCount'] = $this->estimateRepository->getEstimatesStatusCount(getLoggedInUser()->contact->customer_id);
        $data['invoiceStatusCount'] = $this->invoiceRepository->getInvoicesStatusCount(getLoggedInUser()->contact->customer_id);
        $data['proposalStatusCount'] = $this->proposalRepository->getProposalsStatusCount(getLoggedInUser()->contact->customer_id);

        return view('clients.dashboard', $data);
    }
}
