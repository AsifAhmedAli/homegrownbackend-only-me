<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Attribute
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attribute extends Model
{
}
