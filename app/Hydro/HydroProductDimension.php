<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductDimension
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string|null $uom
 * @property float|null $depth
 * @property float|null $height
 * @property float|null $weight
 * @property float|null $width
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDimension whereWidth($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductDimension active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductDimension default()
 * @mixin \Eloquent
 */
class HydroProductDimension extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
}
