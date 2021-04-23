<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Queries\AnnouncementDataTable;
use App\Repositories\AnnouncementRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends AppBaseController
{
    /** @var  AnnouncementRepository */
    private $announcementRepository;

    public function __construct(AnnouncementRepository $announcementRepo)
    {
        $this->announcementRepository = $announcementRepo;
    }

    /**
     * Display a listing of the Announcement.
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
            return DataTables::of((new AnnouncementDataTable())->get($request->only(['status'])))->make(true);
        }
        $statusArr = Announcement::STATUS_ARRAY;

        return view('announcements.index', compact('statusArr'));
    }

    /**
     * Store a newly created Announcement in storage.
     *
     * @param  CreateAnnouncementRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateAnnouncementRequest $request)
    {
        $input = $request->all();
        $input['show_to_clients'] = (isset($input['show_to_clients'])) ? 1 : 0;
        $input['status'] = Announcement::PENDING;
        $announcement = $this->announcementRepository->create($input);

        activity()->performedOn($announcement)->causedBy(getLoggedInUser())
            ->useLog('New Announcement created.')->log($announcement->subject.' Announcement created.');

        return $this->sendSuccess('Announcement saved successfully.');
    }

    /**
     * Display the specified Announcement.
     *
     * @param  Announcement  $announcement
     *
     * @return Factory|View
     */
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified Announcement.
     *
     * @param  Announcement  $announcement
     *
     * @return JsonResponse
     */
    public function edit(Announcement $announcement)
    {
        return $this->sendResponse($announcement, 'Announcement retrieved successfully.');
    }

    /**
     * Update the specified Announcement in storage.
     *
     * @param  UpdateAnnouncementRequest  $request
     *
     * @param  Announcement  $announcement
     *
     * @return JsonResponse
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $input = $request->all();
        $input['show_to_clients'] = (isset($input['show_to_clients'])) ? 1 : 0;
        $input['status'] = (isset($input['status'])) ? 1 : 0;
        $announcement = $this->announcementRepository->update($input, $announcement->id);

        activity()->performedOn($announcement)->causedBy(getLoggedInUser())
            ->useLog('Announcement updated.')->log($announcement->subject.' Announcement updated.');

        return $this->sendSuccess('Announcement updated successfully.');
    }

    /**
     * Remove the specified Announcement from storage.
     *
     * @param  Announcement  $announcement
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Announcement $announcement)
    {
        activity()->performedOn($announcement)->causedBy(getLoggedInUser())
            ->useLog('Announcement deleted.')->log($announcement->subject.' Announcement deleted.');

        $announcement->delete();

        return $this->sendSuccess('Announcement deleted successfully.');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeActiveClient($id)
    {
        $announcement = Announcement::find($id);
        $announcement->update(['show_to_clients' => ! $announcement->show_to_clients]);

        return $this->sendSuccess('Announcement updated successfully.');
    }

    /**
     * @param  Announcement  $announcement
     *
     * @return JsonResponse
     */
    public function getAnnouncementDetails(Announcement $announcement)
    {
        return $this->sendResponse($announcement, 'Announcement retrieved successfully.');
    }

    /**
     * @param  Announcement  $announcement
     *
     * @return mixed
     */
    public function statusChange(Announcement $announcement)
    {
        $announcement = Announcement::find($announcement->id);
        $announcement->update(['status' => ! $announcement->status]);

        return $this->sendSuccess('Announcement status updated successfully.');
    }

}
