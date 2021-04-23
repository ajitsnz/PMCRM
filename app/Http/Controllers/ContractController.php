<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Task;
use App\Queries\ContractDataTable;
use App\Repositories\ContractRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Yajra\DataTables\DataTables;

class ContractController extends AppBaseController
{
    /** @var  ContractRepository */
    private $contractRepository;

    public function __construct(ContractRepository $contractRepo)
    {
        $this->contractRepository = $contractRepo;
    }

    /**
     * Display a listing of the Contract.
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
            return DataTables::of((new ContractDataTable())->get($request->only(['type'])))->make(true);
        }

        $typeArr = ContractType::pluck('name', 'id');

        return view('contracts.index', compact('typeArr'));
    }

    /**
     * Show the form for creating a new Contract.
     *
     * @return Factory|View
     */
    public function create()
    {
        $contractType = $this->contractRepository->getContractType();
        $customer = $this->contractRepository->getCustomer();

        return view('contracts.create', compact('contractType', 'customer'));
    }

    /**
     * Store a newly created Contract in storage.
     *
     * @param  CreateContractRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateContractRequest $request)
    {
        $input = $request->all();
        $input['contract_value'] = removeCommaFromNumbers($input['contract_value']);
        $input['contract_value'] = (! empty($input['contract_value'])) ? $input['contract_value'] : null;
        $contract = $this->contractRepository->create($input);

        activity()->performedOn($contract)->causedBy(getLoggedInUser())
            ->useLog('New Contract created.')->log($contract->subject.' Contract created.');

        Flash::success('Contract saved successfully.');

        return redirect(route('contracts.index'));
    }

    /**
     * Display the specified Contract.
     *
     * @param  Contract  $contract
     *
     * @return Factory|View
     */
    public function show(Contract $contract)
    {
        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $groupName = (request('group') === null) ? 'contract_details' : (request('group'));

        return view("contracts.views.$groupName", compact('contract', 'status', 'priorities', 'groupName'));
    }

    /**
     * Show the form for editing the specified Contract.
     *
     * @param  Contract  $contract
     *
     * @return Factory|View
     */
    public function edit(Contract $contract)
    {
        $contractType = $this->contractRepository->getContractType();
        $customer = $this->contractRepository->getCustomer();

        return view('contracts.edit', compact('contract', 'contractType', 'customer'));
    }

    /**
     * Update the specified Contract in storage.
     *
     * @param  UpdateContractRequest  $request
     *
     * @param  Contract  $contract
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $input = $request->all();
        $input['contract_value'] = removeCommaFromNumbers($input['contract_value']);
        $input['contract_value'] = (! empty($input['contract_value'])) ? $input['contract_value'] : null;
        $contract = $this->contractRepository->update($input, $contract->id);

        activity()->performedOn($contract)->causedBy(getLoggedInUser())
            ->useLog('Contract updated.')->log($contract->subject.' Contract updated.');

        Flash::success('Contract updated successfully.');

        return redirect(route('contracts.index'));
    }

    /**
     * Remove the specified Contract from storage.
     *
     * @param  Contract  $contract
     *
     * @throws Exception
     *
     * @return Response
     */
    public function destroy(Contract $contract)
    {
        activity()->performedOn($contract)->causedBy(getLoggedInUser())
            ->useLog('Contract deleted.')->log($contract->subject.' Contract deleted.');

        $contract->delete();

        return $this->sendSuccess('Contract deleted successfully.');
    }
}
