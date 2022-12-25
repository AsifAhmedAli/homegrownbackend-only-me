<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductFamily
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamily whereUpdatedAt($value)
 * @property-read Collection|HydroProductFamilyItem[] $items
 * @property-read int|null $items_count
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductFamily active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductFamily default()
 * @mixin \Eloquent
 */
class HydroProductFamily extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
    
    public function items()
    {
      return $this->hasMany(HydroProductFamilyItem::class)->orderBy('priority', 'asc');
    }
}
