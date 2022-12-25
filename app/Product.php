<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property int $id
 * @property string|null $image
 * @property string $title
 * @property string|null $slug
 * @property string|null $sku
 * @property int $is_quantity_tracking
 * @property int $continue_selling_when_out_of_stock
 * @property int $quantity
 * @property string|null $barcode ISBN, UPC, GTIN, etc.
 * @property float $price
 * @property float|null $sale_price
 * @property float|null $tax
 * @property float|null $shipping_charges
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $published_at
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereContinueSellingWhenOutOfStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIsQuantityTracking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereShippingCharges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    //
}
