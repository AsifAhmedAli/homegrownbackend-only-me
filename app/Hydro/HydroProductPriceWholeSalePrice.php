<?php

namespace App\Hydro;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductPriceWholeSalePrice
 *
 * @property int $id
 * @property int $hydro_product_price_id
 * @property float|null $yourPrice
 * @property float|null $price
 * @property int|null $qtyStart
 * @property int|null $qtyEnd
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice whereHydroProductPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice whereQtyEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice whereQtyStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPriceWholeSalePrice whereYourPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductPriceWholeSalePrice active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductPriceWholeSalePrice default()
 * @mixin \Eloquent
 */
class HydroProductPriceWholeSalePrice extends Model
{
    use CommonRelations, CommonScopes;
}
