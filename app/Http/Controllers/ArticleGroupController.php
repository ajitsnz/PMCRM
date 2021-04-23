<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleGroupRequest;
use App\Http\Requests\UpdateArticleGroupRequest;
use App\Models\Article;
use App\Models\ArticleGroup;
use App\Queries\ArticleGroupDataTable;
use App\Repositories\ArticleGroupRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ArticleGroupController extends AppBaseController
{
    /** @var  ArticleGroupRepository */
    private $articleGroupRepository;

    public function __construct(ArticleGroupRepository $articleGroupRepo)
    {
        $this->articleGroupRepository = $articleGroupRepo;
    }

    /**
     * Display a listing of the ArticleGroup.
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
            return DataTables::of((new ArticleGroupDataTable())->get())->make(true);
        }

        return view('article_groups.index');
    }

    /**
     * Store a newly created ArticleGroup in storage.
     *
     * @param  CreateArticleGroupRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateArticleGroupRequest $request)
    {
        $input = $request->all();

        $articleGroup = $this->articleGroupRepository->create($input);

        activity()->performedOn($articleGroup)->causedBy(getLoggedInUser())
            ->useLog('New Article Group created.')->log($articleGroup->group_name.' Article Group created.');

        return $this->sendSuccess('Article Group Saved successfully.');
    }

    /**
     * Show the form for editing the specified ArticleGroup.
     *
     * @param  ArticleGroup  $articleGroup
     *
     * @return JsonResponse
     */
    public function edit(ArticleGroup $articleGroup)
    {
        return $this->sendResponse($articleGroup, 'Article Group retrieved successfully.');
    }

    /**
     * Update the specified ArticleGroup in storage.
     *
     * @param  ArticleGroup  $articleGroup
     *
     * @param  UpdateArticleGroupRequest  $request
     *
     * @return JsonResponse
     */
    public function update(UpdateArticleGroupRequest $request, ArticleGroup $articleGroup)
    {
        $input = $request->all();
        $articleGroup = $this->articleGroupRepository->update($input, $articleGroup->id);

        activity()->performedOn($articleGroup)->causedBy(getLoggedInUser())
            ->useLog('Article Group updated.')->log($articleGroup->group_name.' Article Group updated.');

        return $this->sendSuccess('Article Group updated successfully.');
    }

    /**
     * Remove the specified ArticleGroup from storage.
     *
     * @param  ArticleGroup  $articleGroup
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(ArticleGroup $articleGroup)
    {
        $articleGroupId = Article::where('group_id', '=', $articleGroup->id)->exists();

        if ($articleGroupId) {
            return $this->sendError('Article Group used somewhere else.');
        }

        activity()->performedOn($articleGroup)->causedBy(getLoggedInUser())
            ->useLog('Article Group deleted.')->log($articleGroup->group_name.' Article Group deleted.');

        $articleGroup->delete();

        return $this->sendSuccess('Article Group deleted successfully.');
    }
}
