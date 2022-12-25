<?php

namespace App;

use App\Gx\KitReview;
use App\Hydro\HydroProduct;
use App\Models\UserKit;
use App\Utils\Helpers\Helper;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class Kit extends Model
{
    use CommonRelations, CommonScopes, Search;
    public const PROCESSING = 1;
    public const SHIPPED = 2;
    public const COMPLETED = 3;

    public const STATUES = [
      self::PROCESSING => 'Processing',
      self::SHIPPED => 'Shipped',
      self::COMPLETED => 'Completed',
    ];

    public function setFeaturesAttribute($value)
    {
      $this->attributes['features'] = Helper::getTagsValues($value);
    }

    public function reviews() {
        return $this->hasMany(KitReview::class);
    }

    public function user_kits() {
        return $this->hasMany(UserKit::class);
    }

    protected $appends = ['rating'];

    /**
     * @return int
     */
    public function getRatingAttribute()
    {
        $rating = $this->reviews->avg->rating;
        if($rating) {
            return (integer)$this->reviews->avg->rating;
        } else {
            return 0;
        }
    }

    public function products()
    {
        return $this->belongsToMany(HydroProduct::class, 'kit_products')->withPivot('quantity');
    }
}
