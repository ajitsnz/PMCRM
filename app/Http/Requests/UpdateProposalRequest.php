<?php

namespace App\Http\Requests;

use App\Models\Proposal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProposalRequest extends FormRequest
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
        $rules = Proposal::$rules;
        $rules['proposal_number'] = 'required|unique:proposals,proposal_number,'.$this->route('proposal')->id;

        return $rules;
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return Proposal::$messages;
    }
}
