<?php

namespace App\Queries;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AnnouncementDataTable
 * @package App\Queries
 */
class AnnouncementDataTable
{
    /**
     * @param  array  $input
     *
     * @return Announcement|Builder
     */
    public function get($input = [])
    {
        /** @var Announcement $query */
        $query = Announcement::query()->select('announcements.*');

        $query->when(isset($input['status']) && $input['status'] != Announcement::STATUS_ARRAY,
            function (Builder $q) use ($input) {
                $q->where('status', $input['status']);
            });

        return $query;
    }
}
