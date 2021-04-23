<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEstimateRequest;
use App\Http\Requests\UpdateEstimateRequest;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Setting;
use App\Models\Task;
use App\Queries\EstimateDataTable;
use App\Repositories\EstimateRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class EstimateController extends AppBaseController
{
    /** @var  EstimateRepository */
    private $estimateRepository;

    public function __construct(EstimateRepository $estimateRepo)
    {
        $this->estimateRepository = $estimateRepo;
    }

    /**
     * Display a listing of the Estimate.
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
            return DataTables::of((new EstimateDataTable())->get($request->only([
                'customer_id', 'status',
            ])))->make(true);
        }

        $statusArr = Estimate::STATUS;
        $statusCount = $this->estimateRepository->getEstimatesStatusCount();

        return view('estimates.index', compact('statusArr', 'statusCount'));
    }

    /**
     * Show the form for creating a new Estimate.
     *
     * @param  null  $customerId
     *
     * @return Factory|View
     */
    public function create($customerId = null)
    {
        $data = $this->estimateRepository->getSyncList();
        $settings = Setting::pluck('value', 'key');

        return view('estimates.create', compact('data', 'customerId', 'settings'));
    }

    /**
     * Store a newly created Estimate in storage.
     *
     * @param  CreateEstimateRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateEstimateRequest $request)
    {
        try {
            DB::beginTransaction();
            $estimate = $this->estimateRepository->store($request->all());
            DB::commit();

            Flash::success('Estimate saved successfully.');

            return $this->sendResponse($estimate, 'Estimate created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified Estimate.
     *
     * @param  Estimate  $estimate
     *
     * @return Factory|View
     */
    public function show(Estimate $estimate)
    {
        $estimate = $this->estimateRepository->getSyncForEstimateDetail($estimate->id);
        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $groupName = (request('group') === null) ? 'estimate_details' : (request('group'));

        return view("estimates.views.$groupName", compact('estimate', 'status', 'priorities', 'groupName'));
    }

    /**
     * Show the form for editing the specified Estimate.
     *
     * @param  Estimate  $estimate
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Estimate $estimate)
    {
        $estimate = Estimate::with('salesItems.taxes')->findOrFail($estimate->id);
        if ($estimate->status === Estimate::STATUS_EXPIRED || $estimate->status === Estimate::STATUS_DECLINED) {
            return redirect()->back();
        }

        $data = $this->estimateRepository->getSyncList();
        $addresses = [];

        foreach ($estimate->estimateAddresses as $index => $address) {
            $addresses[$index] = $address;
        }

        return view('estimates.edit', compact('data', 'estimate', 'addresses'));
    }

    /**
     * Update the specified Estimate in storage.
     *
     * @param  Estimate  $estimate
     *
     * @param  UpdateEstimateRequest  $request
     *
     * @return JsonResponse
     */
    public function update(Estimate $estimate, UpdateEstimateRequest $request)
    {
        try {
            DB::beginTransaction();
            $estimate = $this->estimateRepository->update($request->all(), $estimate);
            DB::commit();

            Flash::success('Estimate updated successfully.');

            return $this->sendResponse($estimate, 'Estimate created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified Estimate from storage.
     *
     * @param  Estimate  $estimate
     *
     * @return JsonResponse
     */
    public function destroy(Estimate $estimate)
    {
        try {
            DB::beginTransaction();
            $this->estimateRepository->deleteEstimate($estimate);
            DB::commit();

            return $this->sendSuccess('Estimate deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @param  Estimate  $estimate
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function changeStatus(Estimate $estimate, Request $request)
    {
        $this->estimateRepository->changeEstimateStatus($estimate->id, $request->get('status'));

        return $this->sendSuccess('Estimate status updated successfully.');
    }

    /**
     * @param  Estimate  $estimate
     *
     * @return Factory|View
     */
    public function viewAsCustomer(Estimate $estimate)
    {
        $estimate = $this->estimateRepository->getSyncForEstimateDetail($estimate->id);
        $totalPaid = 0;

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('estimates.view_as_customer', compact('estimate', 'totalPaid', 'settings'));
    }

    /**
     * @param  Estimate  $estimate
     *
     * @return mixed
     */
    public function convertToPdf(Estimate $estimate)
    {
        $estimate = $this->estimateRepository->getSyncForEstimateDetail($estimate->id);
        $totalPaid = 0;

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $pdf = PDF::loadView('estimates.estimate_pdf', compact(['estimate', 'totalPaid', 'settings']));

        return $pdf->download(__('messages.estimate.estimate_prefix').$estimate->estimate_number.'.pdf');
    }

    /**
     * @param  Estimate  $estimate
     *
     * @return JsonResponse
     */
    public function convertToInvoice(Estimate $estimate)
    {
        $invoice = $this->estimateRepository->convertToInvoice($estimate);

        return $this->sendResponse($invoice, 'Convert Estimate To Invoice Successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function getCustomerAddress(Request $request)
    {
        $address = getAddressOfCustomer($request->customer_id);
        if(!empty($address[0])){
            $address[0]->country = $address[0]->country != null ? Customer::COUNTRIES[$address[0]->country] : 'null';
        }
        if(!empty($address[1])){
            $address[1]->country = $address[1]->country != null ? Customer::COUNTRIES[$address[1]->country] : 'null';
        }
        
        return $this->sendResponse($address,'Address retrieved successfully');
    }
}
