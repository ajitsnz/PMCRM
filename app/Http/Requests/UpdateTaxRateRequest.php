<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TaxRate;

class UpdateTaxRateRequest extends FormRequest
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
        $rules = TaxRate::$rules;
        $rules['name'] = 'required|unique:tax_rates,name,'.$this->route("taxRate")->id;
        return $rules;
    }
}
