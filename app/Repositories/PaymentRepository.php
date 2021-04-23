<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;

/**
 * Class PaymentRepository
 * @package App\Repositories
 * @version April 22, 2020, 8:39 am UTC
 */
class PaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'owner_id',
        'owner_type',
        'amount_received',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Payment::class;
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return array
     */
    public function getData($invoice)
    {
        $receivedAmount = self::getTotalReceivedAmount($invoice->id);
        $data['amount'] = $invoice->total_amount - $receivedAmount;
        $data['date'] = Carbon::now()->toDateTimeString();
        $data['id'] = $invoice->id;

        return $data;
    }

    /**
     * @param  int  $invoiceId
     *
     * @return int|mixed|string
     */
    public function getTotalReceivedAmount($invoiceId)
    {
        $payments = Payment::whereOwnerId($invoiceId)->get();
        $receivedAmount = $payments->sum('amount_received');

        return $receivedAmount;
    }

    /**
     * @param  array  $input
     *
     * @return bool
     */
    public function store($input)
    {
        $input['send_mail_to_customer_contacts'] = isset($input['send_mail_to_customer_contacts']) ? 1 : 0;
        $input['owner_type'] = Invoice::class;
        $input['amount_received'] = formatNumber($input['amount_received']);
        $input['note'] = $input['note'];
        $payment = Payment::create($input);

        activity()->performedOn($payment)->causedBy(getLoggedInUser())
            ->useLog('Payment success.')->log($payment->paymentMode->name.' Payment success.');

        self::updatePaymentStatus($payment->owner_id);

        return true;
    }

    /**
     * @param  int  $invoiceId
     *
     * @return bool
     */
    public function updatePaymentStatus($invoiceId)
    {
        $invoice = Invoice::findorFail($invoiceId);
        $receivedAmount = self::getTotalReceivedAmount($invoiceId);
        ($invoice->total_amount === $receivedAmount)
            ? $invoice->update(['payment_status' => 2]) : $invoice->update(['payment_status' => 3]);

        return true;
    }
}
