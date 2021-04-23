<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LeadStatus;

class UpdateLeadStatusRequest extends FormRequest
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
        $leadStatus = $this->route('leadStatus');
        $rules = LeadStatus::$rules;
        $rules['name'] = 'required|unique:lead_statuses,name,'.$leadStatus->id;

        return $rules;
    }
}
