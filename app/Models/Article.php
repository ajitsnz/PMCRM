<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * Class Article
 *
 * @package App\Models
 * @version April 6, 2020, 8:30 am UTC
 * @property int $id
 * @property string subject
 * @property integer group_id
 * @property bool|null internal_article
 * @property bool|null $disabled
 * @property string|null $description
 * @property string|null $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ArticleGroup $articleGroup
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereInternalArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @mixin \Eloquent
 * @property-read bool|string $article_attachment
 */
class Article extends Model implements HasMedia
{
    use HasMediaTrait;

    const INTERNAL_ARTICLE_ARR = [
        1 => 'Active',
        0 => 'Deactive',
    ];

    const DISABLED_ARTICLE_ARR = [
        1 => 'Active',
        0 => 'Deactive',
    ];

    public const COLLECTION_ARTICLE_PICTURES = 'article';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject'  => 'required|unique:articles,subject',
        'group_id' => 'required',
        'image'    => 'nullable|mimes:jpeg,png,pdf,docx,doc',
    ];

    public $table = 'articles';

    public $fillable = [
        'subject',
        'group_id',
        'internal_article',
        'disabled',
        'description',
        'image',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'               => 'integer',
        'subject'          => 'string',
        'group_id'         => 'integer',
        'internal_article' => 'boolean',
        'disabled'         => 'boolean',
        'description'      => 'string',
        'image'            => 'string',
    ];

    /**
     * @var array
     */
    protected $appends = ['article_attachment'];

    /**
     * @return bool|string
     */
    public function getArticleAttachmentAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(Article::COLLECTION_ARTICLE_PICTURES)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return false;
    }

    /**
     * @return BelongsTo
     */
    public function articleGroup()
    {
        return $this->belongsTo(ArticleGroup::class, 'group_id');
    }

    /**
     *
     * @return string
     */
    public function getImageUrl()
    {
        $media = $this->getMedia(Article::COLLECTION_ARTICLE_PICTURES)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return getArticleDefaultImage();
    }
}
