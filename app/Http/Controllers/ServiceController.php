<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\Ticket;
use App\Queries\ServiceDataTable;
use App\Repositories\ServiceRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends AppBaseController
{
    /** @var  ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Display a listing of the Service.
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
            return DataTables::of((new ServiceDataTable())->get())->make(true);
        }

        return view('services.index');
    }

    /**
     * Store a newly created Service in storage.
     *
     * @param  CreateServiceRequest  $request
     *
     * @return JsonResource
     */
    public function store(CreateServiceRequest $request)
    {
        $input = $request->all();
        $service = $this->serviceRepository->create($input);

        activity()->performedOn($service)->causedBy(getLoggedInUser())
            ->useLog('New Service created.')->log($service->name.' Service created.');

        return $this->sendSuccess('Service saved successfully.');
    }

    /**
     * Show the form for editing the specified Service.
     *
     * @param  Service  $service
     *
     * @return JsonResource
     */
    public function edit(Service $service)
    {
        return $this->sendResponse($service, 'Service retrieved successfully.');
    }

    /**
     * Update the specified Service in storage.
     *
     * @param  UpdateServiceRequest  $request
     *
     * @param  Service  $service
     *
     * @return JsonResource
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $input = $request->all();
        $service = $this->serviceRepository->update($input, $service->id);

        activity()->performedOn($service)->causedBy(getLoggedInUser())
            ->useLog('Service updated.')->log($service->name.' Service updated.');

        return $this->sendSuccess('Service updated successfully.');
    }

    /**
     * Remove the specified Service from storage.
     *
     * @param  Service  $service
     *
     * @throws Exception
     *
     * @return JsonResource
     */
    public function destroy(Service $service)
    {
        $ticketServiceId = Ticket::where('service_id', '=', $service->id)->exists();

        if ($ticketServiceId) {
            return $this->sendError('Service used somewhere else.');
        }

        activity()->performedOn($service)->causedBy(getLoggedInUser())
            ->useLog('Service deleted.')->log($service->name.' Service deleted.');

        $service->delete();

        return $this->sendSuccess('Service deleted successfully.');
    }
}
