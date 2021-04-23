<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemGroupRequest;
use App\Http\Requests\UpdateItemGroupRequest;
use App\Models\Item;
use App\Models\ItemGroup;
use App\Queries\ItemGroupDataTable;
use App\Repositories\ItemGroupRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ItemGroupController extends AppBaseController
{
    /** @var ItemGroupRepository */
    private $itemGroupRepository;

    public function __construct(ItemGroupRepository $itemGroupRepo)
    {
        $this->itemGroupRepository = $itemGroupRepo;
    }

    /**
     * Display a listing of the ItemGroup.
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
            return DataTables::of((new ItemGroupDataTable())->get())->make(true);
        }

        return view('item_groups.index');
    }

    /**
     * Store a newly created ItemGroup in storage.
     *
     * @param  CreateItemGroupRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateItemGroupRequest $request)
    {
        $input = $request->all();

        $productGroup = $this->itemGroupRepository->create($input);

        activity()->performedOn($productGroup)->causedBy(getLoggedInUser())
            ->useLog('New Product Group created.')->log($productGroup->name.' Product Group created.');

        return $this->sendSuccess('Product Group saved successfully.');
    }

    /**
     * Show the form for editing the specified ItemGroup.
     *
     * @param  ItemGroup  $itemGroup
     *
     * @return JsonResponse
     */
    public function edit(ItemGroup $itemGroup)
    {
        return $this->sendResponse($itemGroup, 'Product Group retrieved successfully.');
    }

    /**
     * Update the specified ItemGroup in storage.
     *
     * @param  ItemGroup  $itemGroup
     *
     * @param  UpdateItemGroupRequest  $request
     *
     * @return JsonResponse
     */
    public function update(ItemGroup $itemGroup, UpdateItemGroupRequest $request)
    {
        $input = $request->all();

        $productGroup = $this->itemGroupRepository->update($input, $itemGroup->id);

        activity()->performedOn($productGroup)->causedBy(getLoggedInUser())
            ->useLog('Product Group updated.')->log($productGroup->name.' Product Group updated.');

        return $this->sendSuccess('Product Group updated successfully.');
    }

    /**
     * Remove the specified ItemGroup from storage.
     *
     * @param  ItemGroup  $itemGroup
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(ItemGroup $itemGroup)
    {
        $itemGroupId = Item::where('item_group_id', '=', $itemGroup->id)->exists();

        if ($itemGroupId) {
            return $this->sendError('Product Group used somewhere else.');
        }

        activity()->performedOn($itemGroup)->causedBy(getLoggedInUser())
            ->useLog('Product Group deleted.')->log($itemGroup->name.' Product Group deleted.');

        $itemGroup->delete();

        return $this->sendSuccess('Product Group deleted successfully.');
    }
}
