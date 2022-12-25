<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductBarCode
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string|null $barcode
 * @property string|null $barcodeType
 * @property string|null $uom
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereBarcodeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductBarCode whereUpdatedAt($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductBarCode active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductBarCode default()
 * @mixin \Eloquent
 */
class HydroProductBarCode extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
}
