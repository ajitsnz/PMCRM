<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Reminder;
use App\Models\Setting;
use App\Models\Task;
use App\Queries\InvoiceDataTable;
use App\Repositories\InvoiceRepository;
use App\Repositories\TicketRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Redirect;
use Throwable;
use Yajra\DataTables\DataTables;

class InvoiceController extends AppBaseController
{
    /** @var  InvoiceRepository */
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }

    /**
     * Display a listing of the Invoice.
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
            return DataTables::of((new InvoiceDataTable())->get($request->only([
                'customer_id', 'payment_status',
            ])))->make(true);
        }

        $paymentStatuses = Invoice::PAYMENT_STATUS;
        $statusCount = $this->invoiceRepository->getInvoicesStatusCount();

        return view('invoices.index', compact('paymentStatuses', 'statusCount'));
    }

    /**
     * Show the form for creating a new Invoice.
     *
     * @param  null  $customerId
     *
     * @return Factory|View
     */
    public function create($customerId = null)
    {
        $data = $this->invoiceRepository->getSyncList();
        $settings = Setting::pluck('value', 'key');

        return view('invoices.create', compact('data', 'customerId', 'settings'));
    }

    /**
     * Store a newly created Invoice in storage.
     *
     * @param  CreateInvoiceRequest  $request
     *
     * @throws Throwable
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateInvoiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $invoice = $this->invoiceRepository->saveInvoice($request->all());
            DB::commit();

            Flash::success('Invoice saved successfully.');

            return $this->sendResponse($invoice, 'Invoice created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified Invoice.
     *
     * @param  Invoice  $invoice
     *
     * @return Factory|View
     */
    public function show(Invoice $invoice)
    {
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->getSyncListForInvoiceDetail($invoice->id);
        $paymentModes = $invoice->paymentModes->where('active', true)->pluck('name', 'id')->toArray();

        /** @var TicketRepository $ticketRepo */
        $ticketRepo = App::make(TicketRepository::class);
        $data = $ticketRepo->getReminderData($invoice->id, Invoice::class);
        $notifiedReminder = Reminder::IS_NOTIFIED;
        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $notes = $this->invoiceRepository->getNotesData($invoice);
        $groupName = (request('group') === null) ? 'invoice_details' : (request('group'));

        return view("invoices.views.$groupName",
            compact('invoice', 'paymentModes', 'data', 'notifiedReminder', 'status', 'priorities', 'notes',
                'groupName'));
    }

    /**
     * Show the form for editing the specified Invoice.
     *
     * @param  Invoice  $invoice
     *
     * @return RedirectResponse
     */
    public function edit(Invoice $invoice)
    {
        if ($invoice->payment_status == Invoice::STATUS_PAID || $invoice->payment_status == Invoice::STATUS_PARTIALLY_PAID || $invoice->payment_status == Invoice::STATUS_CANCELLED) {
            return redirect()->back();
        }

        $data = $this->invoiceRepository->getSyncList();
        $invoice = $this->invoiceRepository->getSyncListForInvoiceDetail($invoice->id);
        $addresses = [];

        foreach ($invoice->invoiceAddresses as $index => $address) {
            $addresses[$index] = $address;
        }

        return view('invoices.edit', compact('data', 'invoice', 'addresses'));
    }

    /**
     * Update the specified Invoice in storage.
     *
     * @param  Invoice  $invoice
     *
     * @param  UpdateInvoiceRequest  $request
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function update(Invoice $invoice, UpdateInvoiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $invoice = $this->invoiceRepository->updateInvoice($request->all(), $invoice->id);
            DB::commit();

            Flash::success('Invoice updated successfully.');

            return $this->sendResponse($invoice, 'Invoice created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified Invoice from storage.
     *
     * @param  Invoice  $invoice
     *
     * @throws Throwable
     *
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(Invoice $invoice)
    {
        try {
            DB::beginTransaction();
            $this->invoiceRepository->deleteInvoice($invoice);
            DB::commit();

            return $this->sendSuccess('Invoice deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return Redirect::back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return Factory|View
     */
    public function viewAsCustomer(Invoice $invoice)
    {
        $invoice = $this->invoiceRepository->getSyncListForInvoiceDetail($invoice->id);
        $totalPaid = 0;

        foreach ($invoice->payments as $payment) {
            $totalPaid += $payment->amount_received;
        }

        return view('invoices.view_as_customer', compact('invoice', 'totalPaid'));
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return mixed
     */
    public function covertToPdf(Invoice $invoice)
    {
        $invoice = $this->invoiceRepository->getSyncListForInvoiceDetail($invoice->id);
        $totalPaid = 0;

        foreach ($invoice->payments as $payment) {
            $totalPaid += $payment->amount_received;
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $pdf = PDF::loadView('invoices.invoice_pdf', compact(['invoice', 'settings', 'totalPaid']));

        return $pdf->download(__('messages.invoice.invoice_prefix').$invoice->invoice_number.'.pdf');
    }

    /**
     * @param  Invoice  $invoice
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function changeStatus(Invoice $invoice, Request $request)
    {
        $this->invoiceRepository->changePaymentStatus($invoice->id, $request->get('paymentStatus'));

        return $this->sendResponse($invoice->id, 'Payment status updated successfully.');
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return mixed
     */
    public function getNotesCount(Invoice $invoice)
    {
        return $this->sendResponse($invoice->notes()->count(), 'Notes count retrieved successfully.');
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
