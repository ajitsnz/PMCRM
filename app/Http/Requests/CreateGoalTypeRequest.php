<?php

namespace App\Http\Requests;

use App\Models\GoalType;
use Illuminate\Foundation\Http\FormRequest;

class CreateGoalTypeRequest extends FormRequest
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
        return GoalType::$rules;
    }
}
