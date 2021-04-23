<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentModeRequest;
use App\Http\Requests\UpdatePaymentModeRequest;
use App\Models\PaymentMode;
use App\Queries\PaymentModeDataTable;
use App\Repositories\PaymentModeRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentModeController extends AppBaseController
{
    /** @var PaymentModeRepository */
    private $paymentModeRepository;

    public function __construct(PaymentModeRepository $paymentModeRepo)
    {
        $this->paymentModeRepository = $paymentModeRepo;
    }

    /**
     * Display a listing of the PaymentMode.
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
            return DataTables::of((new PaymentModeDataTable())->get($request->only([
                'active',
            ])))->make(true);
        }

        $activePaymentMode = PaymentMode::ACTIVE;

        return view('payment_modes.index', compact('activePaymentMode'));
    }

    /**
     * Store a newly created PaymentMode in storage.
     *
     * @param  CreatePaymentModeRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreatePaymentModeRequest $request)
    {
        $input = $request->all();
        $input = $this->prepareInput($input);

        $paymentMode = $this->paymentModeRepository->create($input);

        activity()->performedOn($paymentMode)->causedBy(getLoggedInUser())
            ->useLog('New Payment Mode created.')->log($paymentMode->name.' Payment Mode created.');

        return $this->sendSuccess('Payment Mode saved successfully.');
    }

    /**
     * @param  PaymentMode  $paymentMode
     *
     * @return mixed
     */
    public function show(PaymentMode $paymentMode)
    {
        return $this->sendResponse($paymentMode, 'Payment Mode retrieved successfully.');
    }

    /**
     * Show the form for editing the specified PaymentMode.
     *
     * @param  PaymentMode  $paymentMode
     *
     * @return JsonResponse
     */
    public function edit(PaymentMode $paymentMode)
    {
        return $this->sendResponse($paymentMode, 'Payment Mode retrieved successfully.');
    }

    /**
     * Update the specified PaymentMode in storage.
     *
     * @param  PaymentMode  $paymentMode
     *
     * @param  UpdatePaymentModeRequest  $request
     *
     * @return JsonResponse
     */
    public function update(PaymentMode $paymentMode, UpdatePaymentModeRequest $request)
    {
        $input = $request->all();
        $input = $this->prepareInput($input);
        $paymentMode = $this->paymentModeRepository->update($input, $paymentMode->id);

        activity()->performedOn($paymentMode)->causedBy(getLoggedInUser())
            ->useLog('Payment Mode updated.')->log($paymentMode->name.' Payment Mode updated.');

        return $this->sendSuccess('Payment Mode updated successfully.');
    }

    /**
     * Remove the specified PaymentMode from storage.
     *
     * @param  PaymentMode  $paymentMode
     *
     * @return JsonResponse
     */
    public function destroy(PaymentMode $paymentMode)
    {
        $invoicePaymentMode = $paymentMode->paymentModesForInvoice()->exists();

        if ($invoicePaymentMode) {
            return $this->sendError('Payment Mode used somewhere else.');
        }

        activity()->performedOn($paymentMode)->causedBy(getLoggedInUser())
            ->useLog('Payment Mode deleted.')->log($paymentMode->name.' Payment Mode deleted.');

        $paymentMode->delete();

        return $this->sendSuccess('Payment Mode deleted successfully.');
    }

    /**
     * @param $input
     *
     * @return mixed
     */
    public function prepareInput($input)
    {
        $input['active'] = isset($input['active']) ? 1 : 0;
        return $input;
    }

    /**
     * @param  PaymentMode  $paymentMode
     *
     * @return JsonResponse
     */
    public function activeDeActivePaymentMode(PaymentMode $paymentMode)
    {
        $active = ! $paymentMode->active;
        $paymentMode->update(['active' => $active]);

        return $this->sendSuccess('Payment Mode updated successfully.');
    }
}
