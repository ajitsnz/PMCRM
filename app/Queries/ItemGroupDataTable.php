<?php

namespace App\Queries;

use App\Models\ItemGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class ItemGroupDataTable
{
    /**
     * @return ItemGroup|Builder
     */
    public function get()
    {
        /** @var ItemGroup $query */
        $query = ItemGroup::query()->select('item_groups.*')->withCount('items');

        return $query;
    }
}
