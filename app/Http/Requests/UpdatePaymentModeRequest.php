<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PaymentMode;

class UpdatePaymentModeRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = PaymentMode::$rules;
        $rules['name'] = 'required|unique:payment_modes,name,'.$this->route("paymentMode")->id;
        return $rules;
    }
}
