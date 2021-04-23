<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
        $rules = Project::$rules;
        $rules['project_name'] = 'required|unique:projects,project_name,'.$this->route('project')->id;
        return $rules;
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return Project::$messages;
    }
}
