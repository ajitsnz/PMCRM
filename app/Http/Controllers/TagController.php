<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use App\Queries\TagDataTable;
use App\Repositories\TagRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TagController extends AppBaseController
{
    /** @var  TagRepository $tagRepository*/
    private $tagRepository;

    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepository = $tagRepo;
    }

    /**
     * Display a listing of the Tag.
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
            return DataTables::of((new TagDataTable())->get())->make(true);
        }

        return view('tags.index');
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param  CreateTagRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateTagRequest $request)
    {
        $input = $request->all();

        $tag = $this->tagRepository->create($input);

        activity()->performedOn($tag)->causedBy(getLoggedInUser())
            ->useLog('New Tag created.')->log($tag->name.' Tag created.');

        return $this->sendSuccess('Tag saved successfully.');
    }

    /**
     * @param  Tag  $tag
     *
     * @return mixed
     */
    public function show(Tag $tag)
    {
        return $this->sendResponse($tag, 'Tag retrieved successfully.');
    }

    /**
     * Show the form for editing the specified Tag.
     *
     * @param  Tag  $tag
     *
     * @return JsonResponse
     */
    public function edit(Tag $tag)
    {
        return $this->sendResponse($tag, 'Tag retrieved successfully.');
    }

    /**
     * Update the specified Tag in storage.
     *
     * @param  UpdateTagRequest  $request
     *
     * @param  Tag  $tag
     *
     * @return JsonResponse
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $input = $request->all();

        $tag = $this->tagRepository->update($input, $tag->id);

        activity()->performedOn($tag)->causedBy(getLoggedInUser())
            ->useLog('Tag updated.')->log($tag->name.' Tag updated.');

        return $this->sendSuccess('Tag updated successfully.');
    }

    /**
     * Remove the specified Tag from storage.
     *
     * @param  Tag  $tag
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->sendSuccess('Tag deleted successfully.');
    }
}
