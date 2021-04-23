<?php

namespace App\Http\Requests;

use App\Models\CustomerGroup;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerGroupRequest extends FormRequest
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
        $customerGroup = $this->route('customerGroup');
        $rules = CustomerGroup::$rules;
        $rules['name'] = 'required|unique:customer_groups,name,'.$customerGroup->id;

        return $rules;
    }
}
