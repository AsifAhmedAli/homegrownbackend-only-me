<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AttributeValue
 *
 * @method static whereAttributeId(array|\Illuminate\Http\Request|string $request)
 * @property int $id
 * @property int $attribute_id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttributeValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttributeValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttributeValue whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttributeValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttributeValue extends Model
{
    //
}
