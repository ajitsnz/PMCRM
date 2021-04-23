<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Note;
use App\Models\PaymentMode;
use App\Models\Reminder;
use App\Models\TaxRate;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ExpenseRepository
 * @package App\Repositories
 * @version April 20, 2020, 5:16 am UTC
 */
class ExpenseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'note',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Expense::class;
    }

    /**
     * @return array
     */
    public function getSyncList()
    {
        $data = [];
        $data['expenseCategories'] = ExpenseCategory::pluck('name', 'id')->toArray();
        $data['customers'] = Customer::pluck('company_name', 'id')->toArray();
        $data['taxRates'] = TaxRate::pluck('tax_rate', 'id')->toArray();
        $data['paymentModes'] = PaymentMode::whereActive(true)->pluck('name', 'id')->toArray();
        $data['currencies'] = Customer::CURRENCIES;

        return $data;
    }

    /**
     * @param  array  $input
     *
     * @return bool
     */
    public function create($input)
    {
        try {
            $input['amount'] = formatNumber($input['amount']);
            $input['tax_applied'] = isset($input['tax_applied']) ? 1 : 0;
            $input['billable'] = isset($input['billable']) ? 1 : 0;
            $input['tax_1_id'] = ! empty($input['tax_1_id']) ? $input['tax_1_id'] : null;
            $input['tax_2_id'] = ! empty($input['tax_2_id']) ? $input['tax_2_id'] : null;
            $input['tax_rate'] = ! empty($input['tax_rate']) ? $input['tax_rate'] : null;

            /** @var Expense $expense */
            $expense = Expense::create($input);

            activity()->performedOn($expense)->causedBy(getLoggedInUser())
                ->useLog('New Expense created.')->log($expense->name.' Expense created.');

            if (isset($input['receipt_attachment'])) {
                $expense->addMedia($input['receipt_attachment'])->toMediaCollection(Expense::EXPENSE_RECEIPT,
                    config('app.media_disc'));
            }

            return true;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param  array  $input
     *
     * @param  Expense  $expense
     *
     * @return bool
     */
    public function update($input, $expense)
    {
        try {
            $input['amount'] = formatNumber($input['amount']);
            $input['tax_applied'] = isset($input['tax_applied']) ? 1 : 0;
            $input['billable'] = isset($input['billable']) ? 1 : 0;
            $input['tax_1_id'] = ! empty($input['tax_1_id']) ? $input['tax_1_id'] : null;
            $input['tax_2_id'] = ! empty($input['tax_2_id']) ? $input['tax_2_id'] : null;
            $input['tax_rate'] = ! empty($input['tax_rate']) ? $input['tax_rate'] : null;
            $expense->update($input);

            activity()->performedOn($expense)->causedBy(getLoggedInUser())
                ->useLog('Expense updated.')->log($expense->name.' Expense updated.');

            if (isset($input['receipt_attachment'])) {
                $expense->clearMediaCollection(Expense::EXPENSE_RECEIPT);
                $expense->addMedia($input['receipt_attachment'])->toMediaCollection(Expense::EXPENSE_RECEIPT,
                    config('app.media_disc')
                );
            }

            return true;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     *
     * @param  string  $class
     *
     * @return array
     */
    public function getReminderData($id, $class)
    {
        $data = [];
        $data['reminderTo'] = User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id');
        $data['ownerId'] = $id;

        foreach (Reminder::REMINDER_MODULES as $key => $value) {
            if ($value == $class) {
                $data['moduleId'] = $key;
                break;
            }
        }

        return $data;
    }

    /**
     * @param $expense
     *
     * @return Builder[]|Collection
     */
    public function getCommentData($expense)
    {
        return Comment::with('user.media')->where('owner_id', '=', $expense->id)
            ->where('owner_type', '=', Expense::class)->orderByDesc('created_at')->get();
    }

    /**
     * @param $expense
     *
     * @return Builder[]|Collection
     */
    public function getNotesData($expense)
    {
        return Note::with('user.media')->where('owner_id', '=', $expense->id)
            ->where('owner_type', '=', Expense::class)->orderByDesc('created_at')->get();
    }
}
