<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use App\Repositories\EstimateRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\MemberRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProposalRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class DashboardController
 */
class DashboardController extends AppBaseController
{
    /** @var InvoiceRepository */
    private $invoiceRepository;

    /** @var ProposalRepository */
    private $proposalRepository;

    /** @var EstimateRepository */
    private $estimateRepository;

    /** @var CustomerRepository */
    private $customerRepository;

    /** @var ProjectRepository */
    private $projectRepository;

    /** @var MemberRepository */
    private $memberRepository;

    function __construct(
        InvoiceRepository $invoiceRepository,
        ProposalRepository $proposalRepository,
        EstimateRepository $estimateRepository,
        CustomerRepository $customerRepository,
        ProjectRepository $projectRepository,
        MemberRepository $memberRepository
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->proposalRepository = $proposalRepository;
        $this->estimateRepository = $estimateRepository;
        $this->customerRepository = $customerRepository;
        $this->projectRepository = $projectRepository;
        $this->memberRepository = $memberRepository;
    }

    /**
     *
     * @return Factory|View
     */
    public function index()
    {
        $data['invoiceStatusCount'] = $this->invoiceRepository->getInvoicesStatusCount();
        $data['proposalStatusCount'] = $this->proposalRepository->getProposalsStatusCount();
        $data['estimateStatusCount'] = $this->estimateRepository->getEstimatesStatusCount();
        $data['projectStatusCount'] = $this->projectRepository->getProjectsStatusCount();
        $data['customerCount'] = $this->customerRepository->customerCount();
        $data['memberCount'] = $this->memberRepository->memberCount();

        return view('dashboard.dashboard', $data);
    }
}
