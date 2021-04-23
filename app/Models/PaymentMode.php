<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class PaymentMode
 *
 * @package App\Models
 * @version April 6, 2020, 9:55 am UTC
 * @property string name
 * @property string description
 * @property boolean active
 * @property boolean show_on_pdf
 * @property boolean selected_by_default
 * @property boolean invoices_only
 * @property boolean expenses_only
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentMode extends Model
{
    const ACTIVE = [
        1 => 'Active',
        0 => 'Deactive',
    ];

    /**
     * @var string
     */
    public $table = 'payment_modes';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'description',
        'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                  => 'integer',
        'name'                => 'string',
        'description'         => 'string',
        'active'              => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:payment_modes,name',
    ];

    /**
     * @return BelongsToMany
     */
    public function paymentModesForInvoice()
    {
        return $this->belongsToMany(PaymentMode::class, 'invoice_payment_modes');
    }
}
