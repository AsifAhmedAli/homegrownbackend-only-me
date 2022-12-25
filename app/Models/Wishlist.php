<?php

namespace App\Models;

use App\Hydro\HydroProduct;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Wishlist
 *
 * @property int $id
 * @property int $user_id
 * @property int $hydro_product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist active()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist default()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereUserId($value)
 * @mixin \Eloquent
 */
class Wishlist extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $perPage = 10;

    public function product() {
        return $this->belongsTo(HydroProduct::class, 'hydro_product_id');
    }
}
