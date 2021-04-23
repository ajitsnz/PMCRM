<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContractTypeRequest;
use App\Http\Requests\UpdateContractTypeRequest;
use App\Models\Contract;
use App\Models\ContractType;
use App\Queries\ContractTypeDataTable;
use App\Repositories\ContractTypeRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ContractTypeController extends AppBaseController
{
    /** @var  ContractTypeRepository */
    private $contractTypeRepository;

    public function __construct(ContractTypeRepository $contractTypeRepo)
    {
        $this->contractTypeRepository = $contractTypeRepo;
    }

    /**
     * Display a listing of the ContractType.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return DataTables::of((new ContractTypeDataTable())->get())->make();
        }

        return view('contract_types.index');
    }

    /**
     * Store a newly created ContractType in storage.
     *
     * @param  CreateContractTypeRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateContractTypeRequest $request)
    {
        $input = $request->all();

        $contractType = $this->contractTypeRepository->create($input);

        activity()->performedOn($contractType)->causedBy(getLoggedInUser())
            ->useLog('New Contract Type created.')->log($contractType->name.' Contract Type created.');

        return $this->sendSuccess('Contract Type saved successfully.');
    }

    /**
     * Show the form for editing the specified ContractType.
     *
     * @param  ContractType  $contractType
     *
     * @return JsonResponse
     */
    public function edit(ContractType $contractType)
    {
        return $this->sendResponse($contractType, 'Contract Type retrieved successfully.');
    }

    /**
     * Update the specified ContractType in storage.
     *
     * @param  ContractType  $contractType
     *
     * @param  UpdateContractTypeRequest  $request
     *
     * @return JsonResponse
     */
    public function update(ContractType $contractType, UpdateContractTypeRequest $request)
    {
        $input = $request->all();

        $contractType = $this->contractTypeRepository->update($input, $contractType->id);

        activity()->performedOn($contractType)->causedBy(getLoggedInUser())
            ->useLog('Contract Type updated.')->log($contractType->name.' Contract Type updated.');

        return $this->sendSuccess('Contract Type updated successfully.');
    }

    /**
     * Remove the specified ContractType from storage.
     *
     * @param  ContractType  $contractType
     *
     * @return JsonResponse
     */
    public function destroy(ContractType $contractType)
    {
        $contractTypeId = Contract::where('contract_type_id', '=', $contractType->id)->exists();

        if ($contractTypeId) {
            return $this->sendError('Contract Type used somewhere else.');
        }

        activity()->performedOn($contractType)->causedBy(getLoggedInUser())
            ->useLog('Contract Type deleted.')->log($contractType->name.' Contract Type deleted.');

        $contractType->delete();

        return $this->sendSuccess('Contract Type deleted successfully.');
    }
}
