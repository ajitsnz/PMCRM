<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleGroup;

/**
 * Class ArticleRepository
 * @package App\Repositories
 * @version April 6, 2020, 8:30 am UTC
 */
class ArticleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
        'group_id',
        'internal_article',
        'disabled',
        'description',
        'image',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Article::class;
    }

    /**
     * @return ArticleGroup
     */
    public function getArticleGroups()
    {
        /** @var ArticleGroup $articleGroup */
        return ArticleGroup::get()->pluck('group_name', 'id');
    }

    /**
     * @param  array  $input
     *
     * @return bool
     */
    public function store($input)
    {
        $article = Article::create($input);

        activity()->performedOn($article)->causedBy(getLoggedInUser())
            ->useLog('New Article created.')->log($article->subject.' Article created.');

        if (isset($input['image']) && $input['image']) {
            $article->addMedia($input['image'])->toMediaCollection(Article::COLLECTION_ARTICLE_PICTURES,
                config('app.media_disc'));
        }

        return true;
    }

    /**
     * @param  array  $input
     *
     * @param  int  $id
     *
     * @return bool
     */
    public function update($input, $id)
    {
        $article = Article::find($id);

        activity()->performedOn($article)->causedBy(getLoggedInUser())
            ->useLog('Article updated.')->log($article->subject.' Article updated.');

        if (isset($input['image']) && $input['image']) {
            $article->clearMediaCollection(Article::COLLECTION_ARTICLE_PICTURES);
            $article->addMedia($input['image'])->toMediaCollection(Article::COLLECTION_ARTICLE_PICTURES,
                config('app.media_disc'));
        }

        $article->update($input);

        return true;
    }
}
