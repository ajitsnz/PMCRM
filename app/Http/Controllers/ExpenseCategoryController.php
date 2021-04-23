<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Queries\ExpenseCategoryDataTable;
use App\Repositories\ExpenseCategoryRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ExpenseCategoryController extends AppBaseController
{
    /** @var  ExpenseCategoryRepository */
    private $expenseCategoryRepository;

    public function __construct(ExpenseCategoryRepository $expenseCategoryRepo)
    {
        $this->expenseCategoryRepository = $expenseCategoryRepo;
    }

    /**
     * Display a listing of the ExpenseCategory.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ExpenseCategoryDataTable())->get())->make(true);
        }

        return view('expense_categories.index');
    }

    /**
     * Store a newly created ExpenseCategory in storage.
     *
     * @param  CreateExpenseCategoryRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateExpenseCategoryRequest $request)
    {
        $input = $request->all();

        $expenseCategory = $this->expenseCategoryRepository->create($input);

        activity()->performedOn($expenseCategory)->causedBy(getLoggedInUser())
            ->useLog('New Expense Category created.')->log($expenseCategory->name.' Expense Category created.');

        return $this->sendSuccess('Expense Category saved successfully.');
    }

    /**
     * Show the form for editing the specified ExpenseCategory.
     *
     * @param  ExpenseCategory  $expenseCategory
     *
     * @return JsonResponse
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        return $this->sendResponse($expenseCategory, 'Expense Category retrieved successfully.');
    }

    /**
     * Update the specified ExpenseCategory in storage.
     *
     * @param  ExpenseCategory  $expenseCategory
     *
     * @param  UpdateExpenseCategoryRequest  $request
     *
     * @return JsonResponse
     */
    public function update(ExpenseCategory $expenseCategory, UpdateExpenseCategoryRequest $request)
    {
        $input = $request->all();
        $expenseCategory = $this->expenseCategoryRepository->update($input, $expenseCategory->id);

        activity()->performedOn($expenseCategory)->causedBy(getLoggedInUser())
            ->useLog('Expense Category updated.')->log($expenseCategory->name.' Expense Category updated.');

        return $this->sendSuccess('Expense Category updated successfully.');
    }

    /**
     * Remove the specified ExpenseCategory from storage.
     *
     * @param  ExpenseCategory  $expenseCategory
     *
     * @return JsonResponse
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategoryId = Expense::where('expense_category_id', '=', $expenseCategory->id)->exists();

        if ($expenseCategoryId) {
            return $this->sendError('Expense Category used somewhere else.');
        }

        activity()->performedOn($expenseCategory)->causedBy(getLoggedInUser())
            ->useLog('Expense Category deleted.')->log($expenseCategory->name.' Expense Category deleted.');

        $expenseCategory->delete();

        return $this->sendSuccess('Expense Category deleted successfully.');
    }
}
