<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Queries\PaymentDataTable;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PaymentListing extends Controller
{
    /**
     * Display a listing of the resource.
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
            return Datatables::of((new PaymentDataTable())->get($request->only(['owner_type'])))->make(true);
        }

        return view('listing.payments.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  Payment  $payment
     *
     * @return Factory|View
     */
    public function show(Payment $payment)
    {
        return view('listing.payments.show', compact('payment'));
    }
}
