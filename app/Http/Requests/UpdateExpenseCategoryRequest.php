<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ExpenseCategory;

class UpdateExpenseCategoryRequest extends FormRequest
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
        $expenseCategory = $this->route('expenseCategory');
        $rules = ExpenseCategory::$rules;
        $rules['name'] = 'required|unique:expense_categories,name,'.$expenseCategory->id;

        return $rules;
    }
}
