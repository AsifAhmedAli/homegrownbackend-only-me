<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Author
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Author onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Author withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Author withoutTrashed()
 * @mixin \Eloquent
 */
class Author extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
