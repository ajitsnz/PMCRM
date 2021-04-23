<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\InvoicePaymentMode
 *
 * @property int $id
 * @property int $payment_mode_id
 * @property int $invoice_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|InvoicePaymentMode newModelQuery()
 * @method static Builder|InvoicePaymentMode newQuery()
 * @method static Builder|InvoicePaymentMode query()
 * @method static Builder|InvoicePaymentMode whereCreatedAt($value)
 * @method static Builder|InvoicePaymentMode whereId($value)
 * @method static Builder|InvoicePaymentMode whereInvoiceId($value)
 * @method static Builder|InvoicePaymentMode wherePaymentModeId($value)
 * @method static Builder|InvoicePaymentMode whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\PaymentMode $paymentMode
 */
class InvoicePaymentMode extends Model
{
    /**
     * @var string
     */
    public $table = 'invoice_payment_modes';

    /**
     * @var array
     */
    public $fillable = [
        'invoice_id',
        'payment_mode_id',
    ];

    /**
     * @return BelongsTo
     */
    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode_id', 'id');
    }
}
