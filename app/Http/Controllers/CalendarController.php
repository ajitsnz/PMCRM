<?php

namespace App\Http\Controllers;

use App\Repositories\CalendarRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CalendarController extends AppBaseController
{
    /** @var  CalendarRepository $calendarRepository */
    private $calendarRepository;

    public function __construct(CalendarRepository $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('calendars.index');
    }

    /**
     * @return JsonResponse
     */
    public function calendarList()
    {
        $calendarList = $this->calendarRepository->getCalendarListData();

        return $this->sendResponse($calendarList, 'Calendar List data retrieved successfully.');
    }
}
