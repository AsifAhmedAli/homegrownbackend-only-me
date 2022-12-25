<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductUomConversion
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property float|null $factor The conversion multiplier between units
 * @property int|null $numerator Numerator for conversion factor
 * @property int|null $denominator Denominator for conversion factor
 * @property float|null $inneroffset Offset added to numerator
 * @property float|null $outeroffset Offset added to denominator
 * @property int|null $rounding Denotes how UoM conversion results should be rounded
 * @property string|null $fromsymbol Abbreviation of "from" conversion unit
 * @property int|null $fromdecimalofprecision Denotes how many decimal places to display in "from" value
 * @property string|null $fromname Specifies the “from” conversion unit
 * @property string|null $tosymbol Abbreviation of "to" conversion unit
 * @property int|null $todecimalofprecision Denotes how many decimal places to display in "to" value
 * @property string|null $toname Specifies the "to" conversion unit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereDenominator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereFromdecimalofprecision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereFromname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereFromsymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereInneroffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereNumerator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereOuteroffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereRounding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereTodecimalofprecision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereToname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereTosymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductUomConversion whereUpdatedAt($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductUomConversion active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductUomConversion default()
 * @mixin \Eloquent
 */
class HydroProductUomConversion extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
}
