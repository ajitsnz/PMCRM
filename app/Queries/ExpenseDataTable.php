<?php

namespace App\Queries;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ExpenseDataTable
 * @package App\Queries
 */
class ExpenseDataTable
{
    /**
     * @param  array  $input
     *
     * @return Expense
     */
    public function get($input = [])
    {
        /** @var Expense $query */
        $query = Expense::with(['customer', 'expenseCategory'])->select('expenses.*');

        $query->when(isset($input['expenseCategory']) && $input['expenseCategory'] != ExpenseCategory::pluck('name',
                'id'),
            function (Builder $q) use ($input) {
                $q->where('expense_category_id', '=', $input['expenseCategory']);
            });

        return $query;
    }
}
