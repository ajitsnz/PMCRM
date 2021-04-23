<?php

namespace App\Queries;

use App\Models\PredefinedReply;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PredefinedReplyDataTable
 * @package App\Queries
 */
class PredefinedReplyDataTable
{
    /**
     * @return PredefinedReply|Builder
     */
    public function get()
    {
        /** @var PredefinedReply $query */
        $query = PredefinedReply::query()->select('predefined_replies.*');

        return $query;
    }
}
