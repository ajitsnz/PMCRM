<?php

namespace App\Queries\Clients;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AnnouncementDataTable
 */
class AnnouncementDataTable
{
    /**
     * @return Announcement|Builder
     */
    public function get()
    {
        /** @var Announcement $query */
        $query = Announcement::whereShowToClients(true)->select('announcements.*');

        return $query;
    }
}
