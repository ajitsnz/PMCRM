<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Carbon;

/**
 * Class ExpenseCategory
 *
 * @package App\Models
 * @version April 3, 2020, 9:11 am UTC
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpenseCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExpenseCategory extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:expense_categories,name',
    ];

    /**
     * @var string
     */
    public $table = 'expense_categories';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'name'        => 'string',
        'description' => 'string',
    ];

    /**
     *
     * @return mixed
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id');
    }
}
