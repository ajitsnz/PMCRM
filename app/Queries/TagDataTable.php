<?php

namespace App\Queries;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class TagDataTable
{
    /**
     * @return Tag|Builder
     */
    public function get()
    {
        /** @var Tag $query */
        $query = Tag::query()->select('tags.*');

        return $query;
    }
}
