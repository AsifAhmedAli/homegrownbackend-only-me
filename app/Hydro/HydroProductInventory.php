<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductInventory
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string|null $siteId
 * @property string|null $name
 * @property float|null $availPhysicalByWarehouse
 * @property float|null $availPhysicalTotal
 * @property string|null $bckpInventLocationId
 * @property float|null $bckpAvailPhysicalByWarehouse
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereAvailPhysicalByWarehouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereAvailPhysicalTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereBckpAvailPhysicalByWarehouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereBckpInventLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductInventory whereUpdatedAt($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductInventory active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductInventory default()
 * @mixin \Eloquent
 */
class HydroProductInventory extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
}
