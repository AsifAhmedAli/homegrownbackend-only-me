<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductImage
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property int|null $docRefId
 * @property string|null $docName
 * @property string|null $fileName
 * @property string|null $fileType
 * @property int|null $isDefault
 * @property string|null $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereDocName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereDocRefId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductImage whereUrl($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductImage active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductImage default()
 * @mixin \Eloquent
 */
class HydroProductImage extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
}
