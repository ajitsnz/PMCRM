<?php

namespace App\Queries;

use App\Models\Article;
use App\Models\ArticleGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ArticleDataTable
 * @package App\Queries
 */
class ArticleDataTable
{
    /**
     * @param  array  $input
     *
     * @return Article|Builder
     */
    public function get($input = [])
    {
        /** @var Article $query */
        $query = Article::with('articleGroup')->select('articles.*');
        
        // query for checking the internal article
        $query->when(isset($input['internal_article']) && $input['internal_article'] != Article::INTERNAL_ARTICLE_ARR,
            function (Builder $q) use ($input) {
                $q->where('internal_article', '=', $input['internal_article']);
            });

        // query for checking the disabled article
        $query->when(isset($input['disabled']) && $input['disabled'] != Article::DISABLED_ARTICLE_ARR,
            function (Builder $q) use ($input) {
                $q->where('disabled', '=', $input['disabled']);
            });

        $query->when(isset($input['group_id']) && $input['group_id'] != ArticleGroup::pluck('group_name', 'id'),
            function (Builder $q) use ($input) {
                $q->where('group_id', '=', $input['group_id']);
            });

        return $query;
    }
}
