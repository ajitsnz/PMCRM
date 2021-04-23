<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Invoice;
use App\Models\Setting;
use App\Queries\Clients\InvoiceDataTable;
use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class InvoiceController
 */
class InvoiceController extends AppBaseController
{
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
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
            return DataTables::of((new InvoiceDataTable())->get($request->only(['payment_status'])))->make(true);
        }

        $invoiceStatusCount = $this->invoiceRepository->getInvoicesStatusCount(getLoggedInUser()->contact->customer_id);

        $paymentStatus = Invoice::CLIENT_PAYMENT_STATUS;

        return view('clients.invoices.index', compact('invoiceStatusCount', 'paymentStatus'));
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

        return view('clients.invoices.view_as_customer', compact('invoice', 'totalPaid'));
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
        $pdf = PDF::loadView('clients.invoices.invoice_pdf', compact(['invoice', 'settings', 'totalPaid']));

        return $pdf->download(__('messages.invoice.invoice_prefix').$invoice->invoice_number.'.pdf');
    }
}
