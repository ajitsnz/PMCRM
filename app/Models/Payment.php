<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property string $amount_received
 * @property string $payment_date
 * @property int $payment_mode
 * @property string|null $transaction_id
 * @property string|null $note
 * @property int|null $send_mail_to_customer_contacts
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereAmountReceived($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereNote($value)
 * @method static Builder|Payment whereOwnerId($value)
 * @method static Builder|Payment whereOwnerType($value)
 * @method static Builder|Payment wherePaymentDate($value)
 * @method static Builder|Payment wherePaymentMode($value)
 * @method static Builder|Payment whereSendMailToCustomerContacts($value)
 * @method static Builder|Payment whereTransactionId($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\InvoicePaymentMode $invoicePaymentMode
 */
class Payment extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'amount_received' => 'required',
        'payment_date'    => 'required',
        'payment_mode'    => 'required',
    ];

    public $table = 'payments';

    public $fillable = [
        'owner_id',
        'owner_type',
        'amount_received',
        'payment_date',
        'payment_mode',
        'transaction_id',
        'note',
        'send_mail_to_customer_contacts',
        'stripe_id',
        'meta',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'             => 'integer',
        'owner_id'       => 'integer',
        'owner_type'     => 'string',
        'payment_mode'   => 'integer',
        'transaction_id' => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode');
    }
}
