<?php

namespace App\Queries;

use App\Models\Item;
use App\Models\ItemGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class ItemDataTable
{
    /**
     * @param  array  $input
     *
     * @return Item
     */
    public function get($input = [])
    {
        /** @var Item $query */
        $query = Item::with(['group', 'firstTax', 'secondTax'])->select('items.*');

        $query->when(isset($input['group']) && $input['group'] != ItemGroup::pluck('name', 'id'),
            function (Builder $q) use ($input) {
                $q->where('item_group_id', '=', $input['group']);
            });

        return $query;
    }
}
