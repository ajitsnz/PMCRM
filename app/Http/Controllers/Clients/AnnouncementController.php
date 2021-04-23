<?php

namespace App\Http\Controllers\Clients;


use App\Http\Controllers\AppBaseController;
use App\Models\Announcement;
use App\Queries\Clients\AnnouncementDataTable;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class AnnouncementController
 */
class AnnouncementController extends AppBaseController
{

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
            return Datatables::of((new AnnouncementDataTable())->get())->make(true);
        }

        return view('clients.announcements.index');
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
        return view('clients.announcements.show', compact('announcement'));
    }
}
