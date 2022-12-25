<?php

namespace App;

use App\Hydro\HydroProduct;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * App\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $hydro_product_id
 * @property string|null $unit_price
 * @property int|null $qty
 * @property string|null $line_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct active()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct default()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereLineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderProduct extends Model
{
    use CommonRelations, CommonScopes, Search;
    public function product() {
      return $this->belongsTo(HydroProduct::class, 'hydro_product_id', 'id');
    }

    public function kit() {
        return $this->belongsTo(Kit::class, 'kit_id', 'id');
    }
}
