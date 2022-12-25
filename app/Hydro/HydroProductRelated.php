<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductRelated
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string|null $sku
 * @property string|null $relation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated whereRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRelated whereUpdatedAt($value)
 * @property-read HydroProduct $product
 * @property-read HydroProduct|null $related
 * @method static Builder|HydroProductRelated active()
 * @method static Builder|HydroProductRelated continued()
 * @method static Builder|HydroProductRelated default()
 * @mixin \Eloquent
 */
class HydroProductRelated extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
  
    public function related()
    {
      return $this->belongsTo(HydroProduct::class, 'sku', 'sku');
    }
    
    public function scopeContinued(Builder $builder)
    {
      $builder->where('relation', 'related');
    }
}
