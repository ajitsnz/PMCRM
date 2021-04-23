<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleGroup;
use App\Queries\ArticleDataTable;
use App\Repositories\ArticleRepository;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends AppBaseController
{
    /** @var  ArticleRepository */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepository = $articleRepo;
    }

    /**
     * Display a listing of the Article.
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
            return DataTables::of((new ArticleDataTable())->get($request->only([
                'group_id', 'internal_article', 'disabled',
            ])))->make(true);
        }

        $internalArticle = Article::INTERNAL_ARTICLE_ARR;
        $disabledArticle = Article::DISABLED_ARTICLE_ARR;
        $groupArr = ArticleGroup::pluck('group_name', 'id');

        return view('articles.index', compact('internalArticle', 'disabledArticle', 'groupArr'));
    }

    /**
     * Show the form for creating a new Article.
     *
     * @return Factory|View
     */
    public function create()
    {
        $articleGroups = $this->articleRepository->getArticleGroups();

        return view('articles.create', compact('articleGroups'));
    }

    /**
     * Store a newly created Article in storage.
     *
     * @param  CreateArticleRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateArticleRequest $request)
    {
        $input = $request->all();
        $input['internal_article'] = ! isset($input['internal_article']) ? false : true;
        $input['disabled'] = ! isset($input['disabled']) ? false : true;
        $this->articleRepository->store($input);

        Flash::success('Article saved successfully.');

        return redirect(route('articles.index'));
    }

    /**
     * Display the specified Article.
     *
     * @param  Article  $article
     *
     * @return Factory|View
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified Article.
     *
     * @param  Article  $article
     *
     * @return Factory|View
     */
    public function edit(Article $article)
    {
        $articleGroups = $this->articleRepository->getArticleGroups();

        return view('articles.edit', compact('article', 'articleGroups'));
    }

    /**
     * Update the specified Article in storage.
     *
     * @param  UpdateArticleRequest  $request
     *
     * @param  Article  $article
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $input = $request->all();
        $input['internal_article'] = ! isset($input['internal_article']) ? false : true;
        $input['disabled'] = ! isset($input['disabled']) ? false : true;
        $this->articleRepository->update($input, $article->id);

        Flash::success('Article updated successfully.');

        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified Article from storage.
     *
     * @param  Article  $article
     *
     * @throws Exception
     *
     * @return Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return $this->sendSuccess('Article deleted successfully.');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeActiveInternalArticle($id)
    {
        $internalArticle = Article::findOrFail($id);
        $internalArticle->internal_article = ! $internalArticle->internal_article;
        $internalArticle->save();

        return $this->sendSuccess('Article updated successfully.');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeActiveDisabled($id)
    {
        $articleDisabled = Article::findOrFail($id);
        $articleDisabled->disabled = ! $articleDisabled->disabled;
        $articleDisabled->save();

        return $this->sendSuccess('Article updated successfully.');
    }

    /**
     * @param  Article  $article
     *
     * @throws FileNotFoundException
     *
     * @return Application|ResponseFactory|Response
     */
    public function downloadMedia(Article $article)
    {
        $attachmentMedia = $article->media[0];
        $attachmentPath = $attachmentMedia->getPath();

        if (config('app.media_disc') === 'public') {
            $attachmentPath = (Str::after($attachmentMedia->getUrl(), '/uploads'));
        }

        $file = Storage::disk(config('app.media_disc'))->get($attachmentPath);

        $headers = [
            'Content-Type'        => $article->media[0]->mime_type,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$article->media[0]->file_name}",
            'filename'            => $article->media[0]->file_name,
        ];

        return response($file, 200, $headers);
    }
}
