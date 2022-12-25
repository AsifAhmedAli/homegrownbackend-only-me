<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $path
 * @property int $is_featured
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductImage extends Model
{
    //
}
