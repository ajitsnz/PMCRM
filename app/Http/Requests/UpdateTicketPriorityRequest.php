<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TicketPriority;

class UpdateTicketPriorityRequest extends FormRequest
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
        $rules = TicketPriority::$rules;
        $rules['name'] = 'required|unique:ticket_priorities,name,'.$this->route('ticketPriority')->id;

        return $rules;
    }
}
