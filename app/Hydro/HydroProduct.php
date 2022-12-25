<?php

namespace App\Hydro;

use App\Models\Wishlist;
use App\Review;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use TCG\Voyager\Actions\DeleteAction;
use TCG\Voyager\Actions\RestoreAction;

/**
 * App\Hydro\HydroProduct
 *
 * @property int $id
 * @property int $recid Unique product numeric ID
 * @property string|null $sku Unique product alpha-numeric ID
 * @property string|null $name Product name
 * @property string|null $namealias
 * @property int|null $hydro_category_id Local Auto Incremented Primary key from table hydro_categories
 * @property int|null $categoryid Numeric ID for the category to which this product belongs
 * @property int $sortpriority Numeric value denoting product sort order within its category
 * @property string|null $description Product short description
 * @property string|null $webdescription Product description (HTML formatting included)
 * @property string|null $unitsize Describes the products sellable unit size
 * @property string|null $model Product’s Item Model Group (item type)
 * @property int $isdefault Denotes product as head of family or not
 * @property int $isdiscontinued Denotes whether the product has been discontinued. Note that discontinued products can be purchased if there is still inventory available. Discontinued products will never receive more inventory.
 * @property int $isspecialorder Denotes whether the item is a special order item. Special order items may require greater ship times.
 * @property int $isbuildtoorder Denotes whether the item is a "Build to Order" item. BTO items typically do not stock inventory but are built on demand.
 * @property int $isclearance Denotes whether the item is currently on clearance
 * @property int $issale Denotes whether the item is currently on sale
 * @property int $ishazmat Denotes whether the item is classified as hazmat
 * @property string|null $defaultuom Denotes this item’s default unit of measure
 * @property int|null $defaultuomrecid Numeric ID for this item’s default unit of measure
 * @property int|null $defaultimageid ID of this item’s default image
 * @property string|null $mixmatchgrp Denotes the mix/match discount group that this product belongs to. Items in the same group will be discounted based on total volume
 * @property string|null $warranty Describes the warranty length for this item
 * @property string|null $trackingdimensiongroup Tracking Dimension Group
 * @property string|null $launchdate Marks the launch date
 * @property string|null $salestartdate Marks the sale start date
 * @property string|null $saleenddate Marks the sale end date
 * @property string|null $modifiedon Date this product record was last updated
 * @property string|null $createdon Date this product record was create
 * @property int $is_active
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct ofUser($userID)
 * @method static \Illuminate\Database\Query\Builder|\App\Hydro\HydroProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereCategoryid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereCreatedon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereDefaultimageid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereDefaultuom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereDefaultuomrecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereHydroCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIsbuildtoorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIsclearance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIsdefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIsdiscontinued($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIshazmat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIssale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereIsspecialorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereLaunchdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereMixmatchgrp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereModifiedon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereNamealias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereSaleenddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereSalestartdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereSortpriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereTrackingdimensiongroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereUnitsize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereWarranty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProduct whereWebdescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Hydro\HydroProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Hydro\HydroProduct withoutTrashed()
 * @property-read HydroProductFamily|null $family
 * @property-read HydroProductPrice|null $price
 * @property-read HydroCategory|null $category
 * @property-read Collection|HydroProductAttribute[] $prod_attributes
 * @property-read int|null $prod_attributes_count
 * @property-read Collection|HydroProductBarCode[] $bar_codes
 * @property-read int|null $bar_codes_count
 * @property-read Collection|HydroProductDimension[] $dimensions
 * @property-read int|null $dimensions_count
 * @property-read Collection|HydroProductDocument[] $documents
 * @property-read int|null $documents_count
 * @property-read Collection|HydroProductImage[] $images
 * @property-read int|null $images_count
 * @property-read Collection|HydroProductInventory[] $inventories
 * @property-read int|null $inventories_count
 * @property-read Collection|HydroProductRelated[] $related
 * @property-read int|null $related_count
 * @property-read Collection|HydroProductRestriction[] $restrictions
 * @property-read int|null $restrictions_count
 * @property-read Collection|HydroProductUomConversion[] $uom_conversions
 * @property-read int|null $uom_conversions_count
 * @property int $is_featured
 * @property-read \App\Hydro\HydroProductAttribute|null $brand
 * @property-read mixed|string|null $brand_name
 * @property-read int $rating
 * @property-read \App\Hydro\HydroProductImage|null $image
 * @property-read Collection|\App\Hydro\HydroProductAttribute[] $product_attributes
 * @property-read int|null $product_attributes_count
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read Collection|\App\Hydro\HydroProductAttribute[] $specifications
 * @property-read int|null $specifications_count
 * @property-read Collection|\App\Hydro\HydroProductPriceWholeSalePrice[] $wholeSalePrice
 * @property-read int|null $whole_sale_price_count
 * @method static Builder|HydroProduct active()
 * @method static Builder|HydroProduct continued()
 * @method static Builder|HydroProduct default()
 * @method static Builder|HydroProduct isDefault()
 * @method static Builder|HydroProduct whereIsFeatured($value)
 * @mixin \Eloquent
 * @property-read bool $is_in_stock
 * @method static Builder|HydroProduct featured()
 * @property-read mixed $qty
 * @property string|null $added_to_mailchimp_at
 * @property-read mixed $is_csa
 * @property-read mixed $is_fcc
 * @property-read mixed $is_prop65_warning
 * @property-read Collection|Wishlist[] $isFavorite
 * @property-read int|null $is_favorite_count
 * @method static Builder|HydroProduct child()
 * @method static Builder|HydroProduct whereAddedToMailchimpAt($value)
 */
class HydroProduct extends Model
{
    use Searchable;
    use CommonRelations, CommonScopes, SoftDeletes;

    protected $appends = ['rating', 'qty', 'is_in_stock'];
    protected $with     = ['image:product_recid,url', 'price'];

    public const EXCLUDE_ACTIONS = [DeleteAction::class, RestoreAction::class];
    public const SHOW_BULK_CHECKBOX = false;
    public const CAN_ADD_NEW = false;
    public const CAN_BULK_DELETE = false;
    public const SITE_ID = 55;
    public const PROP65_WARNING = 'CA Prop 65 listed chemical(s)';
    public const FCC = 'FCC_Registration';
    public const CSA = 'CSA_Registration';
    public const WARRANTY = 'Warranty';
    public const MAX_FEATURED_ALLOWED = 3;
    public const MAX_BANNER_PRODUCTS_ALLOWED = 3;

    public const SORTING_OPTIONS = [
      'newest' => [
        'column' => 'hydro_products.createdon',
        'sort' => 'desc'
      ],
      'price-low-to-high' => [
        'column' => 'hydro_product_prices.retailPrice',
        'sort' => 'asc'
      ],
      'price-high-to-low' => [
        'column' => 'hydro_product_prices.retailPrice',
        'sort' => 'desc'
      ],
      'alphabetically-a-z' => [
        'column' => 'hydro_products.name',
        'sort' => 'asc'
      ],
      'sku' => [
        'column' => 'hydro_products.sku',
        'sort' => 'asc'
      ]
    ];

    const DEFAULT_SORTING = [
      'column' => 'createdon',
      'sort' => 'desc'
    ];
  /**
   * Get the index name for the model.
   *
   * @return string
   */
  public function searchableAs()
  {
    return 'searchable_items';
  }
  /**
   * Get the indexable data array for the product.
   *
   * @return array
   */

    public function toSearchableArray()
  {

//      return $data = [
//                      'rating' =>$this->getRatingAttribute(),
//                      'product' => self::findById($this->id)];
      return [
        'id'=>$this->attributes['id'],
        'sku'=>$this->attributes['sku'],
        'created_at'=>$this->attributes['created_at'],
        'slug'=>null,
        'name'=>$this->attributes['name'],
        'image'=>$this->image,
        'price'=>$this->price,
        'category'=>$this->category,
        'brand'=>$this->brand,
        'type'=>"product",
        'is_favorite_count'=>0,
        ];
  }
  public static function findById($id, $userId = 0)
  {
    return self::with([
      'image',
      'category',
      'brand',
      'price',
    ])->withCount([
      'isFavorite' => function ($q) use ($userId) {
        $q->whereUserId($userId);
      }
    ])->select('id', 'name', 'is_active','sku', 'is_featured', 'recid','categoryid', 'created_at')->find($id);
  }
    /**
     * @return BelongsTo
     */
    public function category()
    {
      return $this->belongsTo(HydroCategory::class, 'categoryid', 'hydro_id');
    }

    /**
     * @return HasOne
     */
    public function family()
    {
      return $this->hasOne(HydroProductFamily::class, 'product_recid', 'recid');
    }

    /**
     * @return HasOne
     */
    public function price()
    {
      return $this->hasOne(HydroProductPrice::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function product_attributes()
    {
      return $this->hasMany(HydroProductAttribute::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function bar_codes()
    {
      return $this->hasMany(HydroProductBarCode::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function dimensions()
    {
      return $this->hasMany(HydroProductDimension::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function documents()
    {
      return $this->hasMany(HydroProductDocument::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function images()
    {
      return $this->hasMany(HydroProductImage::class, 'product_recid', 'recid');
    }

    /**
     * @return mixed
     */
    public function image()
    {
      return $this->hasOne(HydroProductImage::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function inventories()
    {
      return $this->hasMany(HydroProductInventory::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function related()
    {
      return $this->hasMany(HydroProductRelated::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function restrictions()
    {
      return $this->hasMany(HydroProductRestriction::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function uom_conversions()
    {
      return $this->hasMany(HydroProductUomConversion::class, 'product_recid', 'recid');
    }

    /**
     * @return HasMany
     */
    public function reviews()
    {
      return $this->hasMany(Review::class, 'hydro_product_id', 'id')->approved();
    }

    /**
     * @return int
     */
    public function getRatingAttribute()
    {
      $rating = $this->reviews->avg->rating;
      if($rating) {
        return $this->reviews->avg->rating;
      } else {
        return 0;
      }
    }

    /**
     * @param Builder $builder
     */
    public function scopeContinued(Builder $builder)
    {
      $builder->where('isdiscontinued', false);
    }

    public function scopeIsDefault(Builder $builder)
    {
        $builder->where('isDefault', 0);
    }

    /**
     * @return HasOne
     */
    public function brand()
    {
      return $this->hasOne(HydroProductAttribute::class, 'product_recid', 'recid')->where('attribute', 'Brand');
    }

    /**
     * @return mixed|string|null
     */
    public function getBrandNameAttribute()
    {
      return optional($this->brand)->value;
    }

    /**
     * @return HasMany
     */
    public function specifications()
    {
      return $this->product_attributes()->whereNotIn('attribute', HydroProductAttribute::ignoreAttributes)->whereNotNull('value')->where('value', '!=', '')->where('value', '!=', '0.0000000000000000')->where('value', '!=', '0');
    }

    /**
     * @return bool
     */
    public function getIsInStockAttribute(): bool
    {
      return $this->qty > 0;
    }

    /**
     * @param Builder|self $q
     */
    public function scopeFeatured($q) {
      $q->whereIsFeatured(true);
    }
    /**
     * @param Builder|self $q
     */
    public function scopeBannerProduct($q) {
      $q->whereIsBannerProduct(1);
    }

    /**
     * @return int
     */
    public function getQtyAttribute()
    {
      $inventory = $this->inventories()->where('siteId', self::SITE_ID)->first();

      if($inventory) {
        return (int)$inventory->availPhysicalByWarehouse;
      }

      return 0;
    }

    public function isFavorite()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getIsProp65WarningAttribute()
    {
      return $this->product_attributes()->where('attribute', self::PROP65_WARNING)->where('value', '!=', '0')->first() ? true : false;
    }

    public function getIsFccAttribute()
    {
      return $this->product_attributes()->where('attribute', self::FCC)->where('value', '!=', '0')->first() ? true : false;
    }

    public function getIsCsaAttribute()
    {
      return $this->product_attributes()->where('attribute', self::CSA)->where('value', '!=', '')->first() ? true : false;
    }

    public function getWarrantyAttribute()
    {
      $warranty = $this->product_attributes()->where('attribute', self::WARRANTY)->where('value', '!=', '')->first();

      return optional($warranty)->value;
    }

    public function scopeChild(Builder $builder)
    {
      $builder->where('isdefault', false);
    }
}
