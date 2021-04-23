<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Setting;
use App\Queries\Clients\ContractDataTable;
use App\Repositories\ContractRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class ContractController
 */
class ContractController extends AppBaseController
{
    /**
     * @var ContractRepository
     */
    private $contractRepository;

    function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
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
            return DataTables::of((new ContractDataTable())->get())->make(true);
        }

        $typeArr = ContractType::pluck('name', 'id');

        return view('clients.contracts.index', compact('typeArr'));
    }

    /**
     * @param  Contract  $contract
     *
     * @return Factory|View
     */
    public function viewAsCustomer(Contract $contract)
    {
        $contract = $this->contractRepository->find($contract->id);

        return view('clients.contracts.view_as_customer', compact('contract'));
    }

    /**
     * @param  Contract  $contract
     *
     * @return mixed
     */
    public function convertToPdf(Contract $contract)
    {
        $contract = $this->contractRepository->find($contract->id);
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $pdf = PDF::loadView('clients.contracts.contract_pdf', compact('contract', 'settings'));

        return $pdf->download($contract->subject.'.pdf');
    }
}
