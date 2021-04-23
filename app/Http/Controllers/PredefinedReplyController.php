<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePredefinedReplyRequest;
use App\Http\Requests\UpdatePredefinedReplyRequest;
use App\Models\PredefinedReply;
use App\Queries\PredefinedReplyDataTable;
use App\Repositories\PredefinedReplyRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PredefinedReplyController extends AppBaseController
{
    /** @var  PredefinedReplyRepository */
    private $predefinedReplyRepository;

    public function __construct(PredefinedReplyRepository $predefinedReplyRepo)
    {
        $this->predefinedReplyRepository = $predefinedReplyRepo;
    }

    /**
     * Display a listing of the PredefinedReply.
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
            return DataTables::of((new PredefinedReplyDataTable())->get())->make(true);
        }

        return view('predefined_replies.index');
    }


    /**
     *  Store a newly created PredefinedReply in storage.
     *
     * @param  CreatePredefinedReplyRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreatePredefinedReplyRequest $request)
    {
        $input = $request->all();
        $predefinedReply = $this->predefinedReplyRepository->create($input);
        activity()->performedOn($predefinedReply)->causedBy(getLoggedInUser())
            ->useLog('New Predefined Reply created.')->log($predefinedReply->name.' Predefined Reply created.');

        return $this->sendSuccess('Predefined Reply saved successfully.');
    }

    /**
     * Show the form for editing the specified PredefinedReply.
     *
     * @param  PredefinedReply  $predefinedReply
     * 
     * @return JsonResponse
     */
    public function edit(PredefinedReply $predefinedReply)
    {
        return $this->sendResponse($predefinedReply, 'Predefined Reply retrieved Successfully.');
    }

    /**
     * Update the specified PredefinedReply in storage.
     *
     * @param  UpdatePredefinedReplyRequest  $request
     *
     * @param  PredefinedReply  $predefinedReply
     *
     * @return JsonResponse
     */
    public function update(UpdatePredefinedReplyRequest $request, PredefinedReply $predefinedReply)
    {
        $input = $request->all();
        $predefinedReply = $this->predefinedReplyRepository->update($input, $predefinedReply->id);
        activity()->performedOn($predefinedReply)->causedBy(getLoggedInUser())
            ->useLog('Predefined Reply updated.')->log($predefinedReply->name.' Predefined Reply updated.');

        return $this->sendSuccess('Predefined Reply updated successfully.');
    }

    /**
     * @param  PredefinedReply  $predefinedReply
     *
     * @return mixed
     */
    public function show(PredefinedReply $predefinedReply)
    {
        return $this->sendResponse($predefinedReply, 'Predefined Replay retrieved successfully.');
    }

    /**
     * Remove the specified PredefinedReply from storage.
     *
     * @param  PredefinedReply  $predefinedReply
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(PredefinedReply $predefinedReply)
    {
        $predefinedReply = PredefinedReply::findOrFail($predefinedReply->id)->delete();

        return $this->sendSuccess('Predefined Reply deleted successfully.');
    }
}
