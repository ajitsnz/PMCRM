<?php

namespace App\Http\Requests;

use App\Models\GoalType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalTypeRequest extends FormRequest
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
        $rules = GoalType::$rules;
        $rules['name'] = 'required|unique:goal_types,name,'.$this->route("goalType")->id;

        return $rules;
    }
}
