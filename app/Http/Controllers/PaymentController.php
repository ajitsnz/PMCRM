<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMode;
use App\Queries\PaymentDataTable;
use App\Repositories\PaymentRepository;
use Carbon\Carbon;
use DB;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;
use Yajra\DataTables\DataTables;

class PaymentController extends AppBaseController
{
    /** @var  PaymentRepository */
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepo)
    {
        $this->paymentRepository = $paymentRepo;
    }

    /**
     * Display a listing of the Payment.
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
            return DataTables::of((new PaymentDataTable())
                ->get($request->only(['owner_id', 'owner_type'])))
                ->make(true);
        }

        return view('payments.index');
    }

    /**
     *  Store a newly created Payment in storage.
     *
     * @param  CreatePaymentRequest  $request
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function store(CreatePaymentRequest $request)
    {
        $input = $request->all();
        $input['amount_received'] = removeCommaFromNumbers($input['amount_received']);

        try {
            DB::beginTransaction();

            $this->paymentRepository->store($input);

            DB::commit();

            return $this->sendSuccess('Payment saved successfully.');
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->sendError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified Payment.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function addPayment(Request $request)
    {
        $invoice = Invoice::findOrFail($request->get('invoice_id'));
        $data = $this->paymentRepository->getData($invoice);

        return $this->sendResponse($data, 'Payment retrieved successfully.');
    }

    /**
     * Remove the specified Payment from storage.
     *
     * @param  Payment  $payment
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Payment $payment)
    {
        activity()->performedOn($payment)->causedBy(getLoggedInUser())
            ->useLog('Payment deleted.')
            ->log($payment->paymentMode->name.' Payment deleted.');

        $this->paymentRepository->delete($payment->id);
        $this->paymentRepository->updatePaymentStatus($payment->owner_id);

        return $this->sendSuccess('Payment deleted successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @throws ApiErrorException
     *
     * @return mixed
     */
    public function createSession(Request $request)
    {
        $invoiceId = $request->get('invoiceId');
        $invoice = Invoice::findOrFail($invoiceId);
        $totalPaid = 0;

        foreach ($invoice->payments as $payment) {
            $totalPaid += $payment->amount_received;
        }

        $finalAmount = $invoice->total_amount - $totalPaid;

        setStripeApiKey();
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data'  => [
                        'product_data' => [
                            'name' => 'Make '.$invoice->invoice_number.' as featured Invoice',
                        ],
                        'unit_amount'  => $finalAmount * 100,
                        'currency'     => 'USD',
                    ],
                    'quantity'    => 1,
                    'description' => 'Make '.$invoice->title.' as featured Invoice',
                ],
            ],
            'client_reference_id'  => $invoiceId,
            'mode'                 => 'payment',
            'success_url'          => url('client/invoice-payment-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => url('client/invoice-failed-payment?error=payment_cancelled'),
        ]);
        $result = [
            'sessionId' => $session['id'],
        ];

        return $this->sendResponse($result, 'Session created successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @throws ApiErrorException
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session_id required');
        }

        setStripeApiKey();

        $sessionData = Session::retrieve($sessionId);

        $stripeID = $sessionData->id;
        $invoiceId = $sessionData->client_reference_id;

        $invoice = Invoice::findOrFail($invoiceId);
        $paymentModeId = PaymentMode::whereName('Stripe')->first()->id;

        $invoiceRecord = [
            'owner_id'        => $invoiceId,
            'owner_type'      => Invoice::class,
            'payment_date'    => Carbon::now(),
            'amount_received' => $invoice->total_amount,
            'payment_mode'    => $paymentModeId,
            'stripe_id'       => $stripeID,
            'meta'            => $sessionData->toJSON(),
        ];

        $payment = Payment::create($invoiceRecord);
        $invoice->update(['payment_status' => Invoice::STATUS_PAID]);

        Flash::success('Your Payment is successfully completed.');

        return redirect(route('clients.invoices.index'));
    }

    /**
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function handleFailedPayment()
    {
        Flash::error('Your Payment is not completed.');

        return redirect(route('clients.invoices.index'));
    }
}
