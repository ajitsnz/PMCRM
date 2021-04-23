<?php

namespace App\Queries;

use App\Models\ArticleGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class ArticleGroupDataTable
{
    /**
     * @return ArticleGroup|Builder
     */
    public function get()
    {
        /** @var ArticleGroup $query */
        $query = ArticleGroup::query()->select('article_groups.*')->withCount('articles');

        return $query;
    }
}
