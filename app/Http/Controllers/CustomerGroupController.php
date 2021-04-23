<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerGroupRequest;
use App\Http\Requests\UpdateCustomerGroupRequest;
use App\Models\CustomerGroup;
use App\Queries\CustomerGroupDataTable;
use App\Repositories\CustomerGroupRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\DataTables;

class CustomerGroupController extends AppBaseController
{
    /**
     * @var CustomerGroupRepository
     */
    private $customerGroupRepository;

    /**
     * CustomerGroupController constructor.
     *
     * @param  CustomerGroupRepository  $customerGroupRepo
     */
    public function __construct(CustomerGroupRepository $customerGroupRepo)
    {
        $this->customerGroupRepository = $customerGroupRepo;
    }

    /**
     * Display a listing of the Customer Group.
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
            return DataTables::of((new CustomerGroupDataTable())->get())->make(true);
        }

        return view('customer-groups.index');
    }

    /**
     * Show the form for editing the specified Customer Group.
     *
     * @param  CustomerGroup  $customerGroup
     *
     * @return mixed
     */
    public function edit(CustomerGroup $customerGroup)
    {
        return $this->sendResponse($customerGroup, 'Customer Group retrieved successfully.');
    }

    /**
     * Update the specified Customer Group in storage.
     *
     * @param  CustomerGroup  $customerGroup
     *
     * @param  UpdateCustomerGroupRequest  $request
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function update(CustomerGroup $customerGroup, UpdateCustomerGroupRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $customerGroup = $this->customerGroupRepository->update($input, $customerGroup->id);
            activity()->causedBy(getLoggedInUser())
                ->performedOn($customerGroup)
                ->useLog('Customer Group updated.')
                ->log($customerGroup->name.' Customer Group updated.');

            DB::commit();

            return $this->sendSuccess('Customer Group updated successfully.');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Store a newly created Customer Group in storage.
     *
     * @param  CreateCustomerGroupRequest  $request
     *
     * @throws Throwable
     *
     * @return void
     */
    public function store(CreateCustomerGroupRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $customerGroup = $this->customerGroupRepository->create($input);
            activity()->causedBy(getLoggedInUser())
                ->performedOn($customerGroup)
                ->useLog('New Customer Group created.')
                ->log($customerGroup->name.' Customer Group created.');

            DB::commit();

            return $this->sendSuccess('Customer Group saved successfully.');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified Customer Group from storage.
     *
     * @param  CustomerGroup  $customerGroup
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(CustomerGroup $customerGroup)
    {
        activity()->causedBy(getLoggedInUser())
            ->performedOn($customerGroup)
            ->useLog('Customer Group deleted.')
            ->log($customerGroup->name.' Customer Group deleted.');

        $customerGroup->delete();

        return $this->sendSuccess('Customer Group deleted successfully.');
    }
}
