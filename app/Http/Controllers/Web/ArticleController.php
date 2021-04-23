<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\Article;
use App\Models\ArticleGroup;
use App\Repositories\ArticleRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class ArticleController
 */
class ArticleController extends AppBaseController
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the Article.
     *
     * @return Factory|View
     */
    public function index()
    {
        $articles = Article::with('media')->get();
        $articlesGroups = ArticleGroup::get();

        return view('web.articles.index', compact('articles', 'articlesGroups'));
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
        $article = $this->articleRepository->find($article->id);
        $articlesGroups = ArticleGroup::get();

        return view('web.articles.show', compact('article', 'articlesGroups'));
    }

    /**
     * @param  Request  $request
     *
     * @throws Throwable
     *
     * @return mixed
     */
    public function searchArticle(Request $request)
    {
        $searchData = $request->get('searchData');
        $articles = Article::with('media')->where('subject', 'LIKE', '%'.$searchData.'%')->get();

        return view('web.articles.articles_list', compact('articles'))->render();
    }
}
