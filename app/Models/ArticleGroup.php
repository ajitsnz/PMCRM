<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;

/**
 * Class ArticleGroup
 *
 * @package App\Models
 * @version April 3, 2020, 4:25 am UTC
 * @property int $id
 * @property string group_name
 * @property string color
 * @property string|null $description
 * @property int order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleGroup extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'group_name' => 'required|unique:article_groups,group_name',
        'color'      => 'required',
        'order'      => 'required',
    ];

    /**
     * @var string
     */
    public $table = 'article_groups';

    /**
     * @var array
     */
    public $fillable = [
        'group_name',
        'color',
        'description',
        'order',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'group_name'  => 'string',
        'color'       => 'string',
        'description' => 'string',
        'order'       => 'integer',
    ];

    /**
     * @return mixed
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'group_id');
    }
}
