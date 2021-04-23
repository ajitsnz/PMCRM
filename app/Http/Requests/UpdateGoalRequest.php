<?php

namespace App\Http\Requests;

use App\Models\Goal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalRequest extends FormRequest
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
        $id = $this->route('goal')->id;
        $rules = Goal::$rules;
        $rules['subject'] = 'required|unique:goals,subject,'.$id;

        return $rules;
    }

    /**
     *
     *
     * @return array
     */
    public function messages()
    {
        return Goal::$messages;
    }
}
