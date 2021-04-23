<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class PredefinedReply
 *
 * @package App\Models
 * @version April 3, 2020, 4:54 am UTC
 * @property string reply_name
 * @property string|null body
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PredefinedReply onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply whereReplyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedReply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PredefinedReply withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PredefinedReply withoutTrashed()
 * @mixin \Eloquent
 */
class PredefinedReply extends Model
{
    public $table = 'predefined_replies';

    public $fillable = [
        'reply_name',
        'body',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'reply_name' => 'string',
        'body'       => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'reply_name' => 'required|unique:predefined_replies,reply_name',
    ];
}
