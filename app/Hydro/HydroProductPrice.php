<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductPrice
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property float|null $retailPrice
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice whereRetailPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductPrice whereUpdatedAt($value)
 * @property-read Collection|HydroProductPriceWholeSalePrice[] $whole_sale_prices
 * @property-read int|null $whole_sale_prices_count
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductPrice active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductPrice default()
 * @mixin \Eloquent
 */
class HydroProductPrice extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
    
    public function whole_sale_prices()
    {
      return $this->hasMany(HydroProductPriceWholeSalePrice::class);
    }
}
