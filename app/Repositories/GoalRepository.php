<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Goal;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class GoalRepository
 * @package App\Repositories
 * @version April 21, 2020, 8:30 am UTC
 */
class GoalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
        'user_id',
        'goal_type_id',
        'description',
        'start_time',
        'end_date',
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
        return Goal::class;
    }

    /**
     * @param  array  $input
     *
     */
    public function store($input)
    {
        $goalInputs = Arr::except($input, ['users']);
        $goalInputs['is_notify'] = (isset($goalInputs['is_notify']) && ! empty($goalInputs['is_notify'])) ? 1 : 0;
        $goalInputs['is_not_notify'] = (isset($goalInputs['is_not_notify']) && ! empty($goalInputs['is_not_notify'])) ? 1 : 0;

        /** @var Goal $goal */
        $goal = $this->create($goalInputs);

        activity()->performedOn($goal)->causedBy(getLoggedInUser())
            ->useLog('New Goal created.')->log($goal->subject.' Goal created.');

        if (isset($input['users']) && ! empty($input['users'])) {
            $goal->goalMembers()->sync($input['users']);
        }
    }

    /**
     * @param  int  $id
     *
     * @param  array  $input
     *
     * @return Goal
     */
    public function updateGoal($id, $input)
    {
        $goalInputs = Arr::except($input, ['users']);
        $goalInputs['is_notify'] = (isset($goalInputs['is_notify']) && ! empty($goalInputs['is_notify'])) ? 1 : 0;
        $goalInputs['is_not_notify'] = (isset($goalInputs['is_not_notify']) && ! empty($goalInputs['is_not_notify'])) ? 1 : 0;

        /** @var Goal $goal */
        $goal = $this->update($goalInputs, $id);

        activity()->performedOn($goal)->causedBy(getLoggedInUser())
            ->useLog('Goal updated.')->log($goal->subject.' Goal updated.');

        if (isset($input['users']) && ! empty($input['users'])) {
            $goal->goalMembers()->sync($input['users']);
        }

        return $goal;
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function getGoalDetails($id)
    {
        $goal = Goal::with(['goalMembers'])->find($id);

        return $goal;
    }

    /**
     * @return Collection
     */
    public function getStaffMember()
    {
        /** @var User $user */
        return User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id');
    }


    public function countGoalProgress($data)
    {
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $achievement = $data['achievement'];

        if ($data['goal_ype'] == Goal::INVOICE_AMOUNT) {
            $goalCountByInvoice = Invoice::wherePaymentStatus(Invoice::STATUS_PAID)->whereBetween('invoice_date',
                [$startDate, $endDate])->sum('total_amount');

            if ($goalCountByInvoice >= $achievement) {
                return '100';
            } else {
                return number_format(($goalCountByInvoice * 100) / $achievement);
            }
        } elseif ($data['goal_ype'] == Goal::CONVERT_X_LEAD) {
            $convertXLeads = Lead::whereLeadConvertCustomer(true)->whereBetween('lead_convert_date',
                [$startDate, $endDate])->count();
            if ($convertXLeads >= $achievement) {
                return '100';
            } else {
                return number_format(($convertXLeads * 100) / $achievement);
            }
        } elseif ($data['goal_ype'] == Goal::INCREASE_CUSTOMER_NUMBER) {
            $customers = Customer::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=',
                $endDate)->count();
            if ($customers >= $achievement) {
                return '100';
            } else {
                return number_format(($customers * 100) / $achievement);
            }
        }
    }
}
