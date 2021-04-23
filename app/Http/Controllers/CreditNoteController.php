<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCreditNoteRequest;
use App\Http\Requests\UpdateCreditNotRequest;
use App\Models\Address;
use App\Models\CreditNote;
use App\Models\Customer;
use App\Models\Setting;
use App\Queries\CreditNoteDataTable;
use App\Repositories\CreditNoteRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\DataTables;

class CreditNoteController extends AppBaseController
{
    /** @var  CreditNoteRepository */
    private $creditNoteRepository;

    public function __construct(CreditNoteRepository $creditNoteRepo)
    {
        $this->creditNoteRepository = $creditNoteRepo;
    }

    /**
     * Display a listing of the CreditNotes.
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
            return DataTables::of((new CreditNoteDatatable())->get($request->only('customer_id',
                'payment_status')))->make(true);
        }

        $paymentStatuses = CreditNote::PAYMENT_STATUS;
        $statusCount = $this->creditNoteRepository->getStatusCount();

        return view('credit_notes.index', compact('paymentStatuses', 'statusCount'));
    }

    /**
     * Show the form for creating a new CreditNote.
     *
     * @param  null  $customerId
     *
     * @return Factory|View
     */
    public function create($customerId = null)
    {
        $data = $this->creditNoteRepository->getSyncList();
        $settings = Setting::pluck('value', 'key');

        return view('credit_notes.create', compact('data', 'customerId', 'settings'));
    }

    /**
     * Store a newly created CreditNote in storage.
     *
     * @param  CreateCreditNoteRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateCreditNoteRequest $request)
    {
        try {
            DB::beginTransaction();
            $creditNote = $this->creditNoteRepository->saveCreditNote($request->all());
            DB::commit();

            Flash::success('Credit Note saved successfully.');

            return $this->sendResponse($creditNote, 'Credit Note created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified CreditNote.
     *
     * @param  CreditNote  $creditNote
     *
     * @return Factory|View
     */
    public function show(creditNote $creditNote)
    {
        $creditNote = $this->creditNoteRepository->getSyncListForCreditNoteDetail($creditNote->id);

        return view('credit_notes.show', compact('creditNote'));
    }

    /**
     * Update the specified CreditNote in storage.
     *
     * @param  CreditNote  $creditNote
     *
     * @param  UpdateCreditNotRequest  $request
     *
     * @return JsonResponse
     */
    public function update(CreditNote $creditNote, UpdateCreditNotRequest $request)
    {
        try {
            DB::beginTransaction();
            $creditNote = $this->creditNoteRepository->updateCreditNote($request->all(), $creditNote->id);
            DB::commit();

            Flash::success('Credit Note updated successfully.');

            return $this->sendResponse($creditNote, 'Credit Note created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified CreditNote.
     *
     * @param  CreditNote  $creditNote
     *
     * @return Factory|View
     */
    public function edit(CreditNote $creditNote)
    {
        if($creditNote->payment_status == CreditNote::PAYMENT_STATUS_CLOSED){
            return redirect()->back();
        }
        $creditNote = CreditNote::with(['creditNoteAddresses', 'salesItems', 'salesItems.taxes'])->whereId($creditNote->id)->first();
        $data = $this->creditNoteRepository->getSyncList();
        $addresses = [];

        foreach ($creditNote->creditNoteAddresses as $index => $address) {
            $addresses[$index] = $address;
        }

        return view('credit_notes.edit', compact('data', 'creditNote', 'addresses'));
    }

    /**
     * Remove the specified CreditNote from storage.
     *
     * @param  CreditNote  $creditNote
     *
     * @throws Throwable
     *
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(CreditNote $creditNote)
    {
        try {
            DB::beginTransaction();
            $this->creditNoteRepository->deleteCreditNote($creditNote);
            DB::commit();

            return $this->sendSuccess('Credit Note deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @param  CreditNote  $creditNote
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function changePaymentStatus(CreditNote $creditNote, Request $request)
    {
        $this->creditNoteRepository->changePaymentStatus($creditNote->id, $request->get('paymentStatus'));

        return $this->sendSuccess('Credit Note details updated successfully.');
    }

    /**
     * @param  CreditNote  $creditNote
     *
     * @return Factory|View
     */
    public function viewAsCustomer(CreditNote $creditNote)
    {
        $creditNote = $this->creditNoteRepository->getSyncListForCreditNoteDetail($creditNote->id);
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $currency = Customer::CURRENCIES[$creditNote->currency];

        return view('credit_notes.view_as_customer', compact('creditNote', 'settings', 'currency'));
    }

    /**
     * @param  CreditNote  $creditNote
     *
     * @return mixed
     */
    public function convertToPdf(CreditNote $creditNote)
    {
        $creditNote = $this->creditNoteRepository->getSyncListForCreditNoteDetail($creditNote->id);
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $currency = Customer::CURRENCIES[$creditNote->currency];

        $pdf = PDF::loadView('credit_notes.credit_note_pdf', compact(['creditNote', 'settings', 'currency']));

        return $pdf->download(__('messages.credit_note.credit_note_prefix').$creditNote->credit_note_number.'.pdf');
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
