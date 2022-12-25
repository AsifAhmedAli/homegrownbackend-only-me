<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductDocument
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string|null $docName
 * @property string|null $fileName
 * @property string|null $fileType
 * @property int|null $isDefault
 * @property string|null $url
 * @property string|null $lastModified
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereDocName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereLastModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductDocument whereUrl($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductDocument active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductDocument default()
 * @mixin \Eloquent
 */
class HydroProductDocument extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
}
