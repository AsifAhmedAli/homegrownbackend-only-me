<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Review
 *
 * @property int $id
 * @property int|null $reviewer_id
 * @property int $hydro_product_id
 * @property int $rating
 * @property string $reviewer_name
 * @property string $comment
 * @property int $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static Builder|Review active()
 * @method static Builder|Review approved()
 * @method static Builder|Review default()
 * @method static Builder|Review newModelQuery()
 * @method static Builder|Review newQuery()
 * @method static Builder|Review ofCart($cartID)
 * @method static Builder|Review ofProduct($productID)
 * @method static Builder|Review ofUser($userID)
 * @method static Builder|Review query()
 * @method static Builder|Review whereComment($value)
 * @method static Builder|Review whereCreatedAt($value)
 * @method static Builder|Review whereHydroProductId($value)
 * @method static Builder|Review whereId($value)
 * @method static Builder|Review whereIsApproved($value)
 * @method static Builder|Review whereRating($value)
 * @method static Builder|Review whereReviewerId($value)
 * @method static Builder|Review whereReviewerName($value)
 * @method static Builder|Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    use CommonRelations, CommonScopes, Search;
  
    public const CAN_ADD_NEW = false;

    public function scopeApproved(Builder $q)
    {
      $q->where('is_approved', true);
    }
    public function user(){
        return $this->belongsTo(User::class,'reviewer_id');
    }
}
