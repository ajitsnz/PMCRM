<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Articles extends SearchableComponent
{
    public $internalArticle = '';
    public $filterDisabled = '';
    public $articleGroup = '';
    
    public function render()
    {
        $articles = $this->searchArticles();

        return view('livewire.articles', [
            'articles' => $articles,
        ])->with("search");
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchArticles()
    {
        $this->setQuery($this->getQuery()->with(['articleGroup', 'media']));

        $this->getQuery()->when($this->internalArticle !== '', function (Builder $q) {
            $q->where('internal_article', $this->internalArticle);
        });

        $this->getQuery()->when($this->filterDisabled !== '', function (Builder $q) {
            $q->where('disabled', $this->filterDisabled);
        });

        $this->getQuery()->when($this->articleGroup !== '', function (Builder $q) {
            $q->where('group_id', $this->articleGroup);
        });


        return $this->paginate();
    }

    /**
     * @param $articleId
     */
    public function deleteArticle($articleId)
    {
        $article = Article::find($articleId);
        activity()->performedOn($article)->causedBy(getLoggedInUser())
            ->useLog('Article deleted.')->log($article->subject.' Article deleted.');
        $article->delete();
        $this->dispatchBrowserEvent('deleted');
        $this->searchArticles();
    }
    
    public function filterInternalArticle($articleId)
    {
        $this->internalArticle = $articleId;
    }

    public function filterDisabledArticle($articleId)
    {
        $this->filterDisabled = $articleId;
    }

    public function filterArticleGroup($articleId)
    {
        $this->articleGroup = $articleId;
    }
    
    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'deleteArticle',
        'filterInternalArticle',
        'filterDisabledArticle',
        'filterArticleGroup',
    ];

    /**
     * @return mixed|string
     */
    function model()
    {
        return Article::class;
    }

    /**
     * @return mixed|string[]
     */
    function searchableFields()
    {
        return [
            'subject',
            'articleGroup.group_name'
        ];
    }

    /**
     *
     * @return Builder
     */
    public function filterResults()
    {
        $searchableFields = $this->searchableFields();
        $search = $this->search;

        $this->getQuery()->when(! empty($search), function (Builder $q) use ($search, $searchableFields) {
            $this->getQuery()->where(function (Builder $q) use ($search, $searchableFields) {
                $searchString = '%'.$search.'%';
                foreach ($searchableFields as $field) {
                    if (Str::contains($field, '.')) {
                        $field = explode('.', $field);
                        $q->orWhereHas($field[0], function (Builder $query) use ($field, $searchString) {
                            $query->whereRaw("lower($field[1]) like ?", $searchString);
                        });
                    } else {
                        $q->orWhereRaw("lower($field) like ?", $searchString);
                    }
                }
            });

        });

        return $this->getQuery();
    }
}
