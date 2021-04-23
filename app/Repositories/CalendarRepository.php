<?php

namespace App\Repositories;

use App\Models\Announcement;

/**
 * Class AppointmentCalendarRepository
 * @package App\Repositories
 * @version March 4, 2020, 5:22 am UTC
 */
class CalendarRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        // ...
    }

    /**
     * @return array
     */
    public function getCalendarListData()
    {
        /** @var Announcement $announcement */
        $announcements = Announcement::get()->toArray();

        $result = [];
        foreach ($announcements as $announcement) {
            $data['id'] = $announcement['id'];
            $data['title'] = $announcement['subject'];
            $data['date'] = $announcement['date'];
            $result[] = $data;
        }

        return array_values($result);
    }
}
