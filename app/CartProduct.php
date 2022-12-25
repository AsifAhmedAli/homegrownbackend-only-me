<?php

namespace App;

use App\Hydro\HydroProduct;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\CartProduct
 *
 * @property int $id
 * @property int $cart_id
 * @property int $hydro_product_id
 * @property float $price
 * @property float $shipping_charges
 * @property int $quantity
 * @property string|null $user_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct active()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct default()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereShippingCharges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereUserNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereHuProductId($value)
 * @mixin Eloquent
 * @property-read HydroProduct $product
 * @property-read float|int $total_price
 * @property-read \App\Cart $cart
 */
class CartProduct extends Model
{
    use CommonRelations, CommonScopes, Search;
    protected $touches = ['cart'];
    protected $appends = ['total_price'];
    protected $fillable = ['cart_id'];

    /**
     * @return BelongsTo
     */
    public function product()
    {
      return $this->belongsTo(HydroProduct::class, 'hydro_product_id', 'id');
    }

    public function kit()
    {
        return $this->belongsTo(Kit::class, 'kit_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function cart()
    {
      return $this->belongsTo(Cart::class);
    }

    /**
     * @return float|int
     */
    public function getTotalPriceAttribute()
    {
      return $this->attributes['price'] * $this->attributes['quantity'];
    }
}
