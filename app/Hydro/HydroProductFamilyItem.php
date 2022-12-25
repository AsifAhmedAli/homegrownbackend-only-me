<?php

namespace App\Hydro;

use App\Utils\Helpers\Helper;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductFamilyItem
 *
 * @property int $id
 * @property int $hydro_product_family_id
 * @property string|null $sku
 * @property int|null $priority
 * @property int|null $isDefault
 * @property string|null $unitSize
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem whereHydroProductFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem whereUnitSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductFamilyItem whereUpdatedAt($value)
 * @property-read HydroProduct|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductFamilyItem active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductFamilyItem default()
 * @mixin \Eloquent
 * @property-read mixed $is_continued
 */
class HydroProductFamilyItem extends Model
{
    use CommonRelations, CommonScopes;
    protected $appends = ['is_continued'];
    
    public function product()
    {
      return $this->belongsTo(HydroProduct::class, 'sku', 'sku')->continued();
    }
    
    public function getIsContinuedAttribute()
    {
      return !Helper::empty($this->product);
    }
}
