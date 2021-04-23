<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends AppBaseController
{
    /**
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $activityLogs = ActivityLog::with('createdBy')->orderBy('created_at', 'DESC')->paginate(10);

        if ($request->ajax()) {
            try {
                return $this->sendResponse($activityLogs, 'Activity log data retrieved successfully.');
            } catch (\Exception $e) {
                return $this->sendError($e, '404');
            }
        }

        return view('activity_logs.index', compact('activityLogs'));
    }
}
