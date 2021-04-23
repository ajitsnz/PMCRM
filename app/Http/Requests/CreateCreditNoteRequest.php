<?php

namespace App\Http\Requests;

use App\Models\CreditNote;
use Illuminate\Foundation\Http\FormRequest;

class CreateCreditNoteRequest extends FormRequest
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
        return CreditNote::$rules;
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return CreditNote::$messages;
    }
}
