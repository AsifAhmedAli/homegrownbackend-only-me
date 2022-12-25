<?php

namespace App;

use App\Hydro\HydroCategory;
use App\Hydro\HydroProduct;
use App\Utils\Constants\DropDown;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Coupon as ModuleCoupon;

/**
 * App\Coupon
 *
 * @property int $id
 * @property string $code
 * @property string|null $description
 * @property int $is_featured
 * @property string|null $featured_redirection
 * @property string $type
 * @property int $amount
 * @property float $minimum_spent
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $used_counter
 * @property int $usage_limit
 * @property int $usage_limit_per_user
 * @property string|null $user_ids
 * @property string|null $product_ids
 * @property string|null $exclude_product_ids
 * @property string|null $category_ids
 * @property string|null $exclude_category_ids
 * @property int $is_shipping_free
 * @property int $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCategoryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereExcludeCategoryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereExcludeProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereFeaturedRedirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereIsShippingFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereMinimumSpent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUsageLimitPerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUsedCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUserIds($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|HydroCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|HydroProduct[] $products
 * @property-read int|null $products_count
 * @method static Builder|Coupon active()
 */
class Coupon extends Model
{
    public static function findByCode($code)
    {
        return static::whereCode($code)->first();
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', true)->whereDate('start_date', '<=', [date('Y-m-d')])
            ->whereDate('end_date', '>=', [date('Y-m-d')])->where('usage_limit', '>', 0);
    }

    public function valid()
    {
        if ($this->hasStartDate() && $this->hasEndDate()) {
            return $this->startDateIsValid() && $this->endDateIsValid() && $this->usage_limit > 0;
        }

        if ($this->hasStartDate()) {
            return $this->startDateIsValid() && $this->usage_limit > 0;
        }

        if ($this->hasEndDate()) {
            return $this->endDateIsValid() && $this->usage_limit > 0;
        }

        return true;
    }

    private function hasStartDate()
    {
        return !is_null($this->start_date);
    }

    private function hasEndDate()
    {
        return !is_null($this->end_date);
    }

    private function startDateIsValid()
    {
        return today() >= $this->start_date;
    }

    private function endDateIsValid()
    {
        return today() <= $this->end_date;
    }

    public function notSpentTheRequiredAmount(Cart $cart)
    {
        if (is_null($this->minimum_spent)) {
            return false;
        }

        return $cart->sub_total < $this->minimum_spent;
    }

    public function isProductDiscount()
    {
        return $this->type == DropDown::FIXED_PRODUCT || $this->type == DropDown::PERCENT_PRODUCT;
    }

    public function isKitDiscount()
    {
        return $this->type == DropDown::FIXED_KIT || $this->type == DropDown::PERCENT_KIT;
    }

    public function isCategoryDiscount()
    {
        return $this->type == DropDown::FIXED_CATEGORY || $this->type == DropDown::PERCENT_CATEGORY;
    }

    public function isPercent()
    {
        return $this->type == DropDown::PERCENT_CATEGORY || $this->type == DropDown::PERCENT_PRODUCT || $this->type == DropDown::PERCENT_SITE_WIDE || $this->type == DropDown::PERCENT_KIT;
    }

    public function isSiteWide()
    {
        return $this->type == DropDown::PERCENT_SITE_WIDE || $this->type == DropDown::FIXED_SITE_WIDE;
    }

    public function products()
    {
        return $this->belongsToMany(HydroProduct::class);
    }

    public function kits()
    {
        return $this->belongsToMany(Kit::class);
    }

    public function categories()
    {
        return $this->belongsToMany(HydroCategory::class);
    }
}
