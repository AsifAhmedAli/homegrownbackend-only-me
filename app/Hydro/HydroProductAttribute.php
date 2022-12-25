<?php

namespace App\Hydro;

use App\Utils\Helpers\Helper;
use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Hydro\HydroProductAttribute
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string $attribute
 * @property string|null $value
 * @property int|null $dataType
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereDataType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductAttribute whereValue($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductAttribute active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductAttribute default()
 * @mixin Eloquent
 */

class HydroProductAttribute extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
    
    public const ignoreAttributes = [
      'AltSearchTerms',
      'Brand',
      'Clearance',
      'IsClearance',
      'HouseBrand',
      'HousePremium',
      'IsNew',
      'IsPreorder',
      'MixMatchGrp',
      'NewEnable',
      'OMRI',
      'WebTitle',
      HydroProduct::CSA,
      HydroProduct::WARRANTY,
      HydroProduct::PROP65_WARNING
    ];
    
    public const MAP = [
      'Unboxed4_Height' => 'Height (Unboxed)',
      'Unboxed3_Length' => 'Length (Unboxed)',
      'Unboxed1_Weight' => 'Weight (Unboxed)',
      'Unboxed2_Width' => 'Width (Unboxed)',
    ];
    
    public function getAttributeAttribute($name)
    {
      return Helper::arrayIndex(self::MAP, $name, $name);
    }
}
