<?php
  
  namespace App;
  
  use App\Utils\Constants\Constant;
  use App\Utils\Traits\CommonRelations;
  use App\Utils\Traits\CommonScopes;
  use App\Utils\Traits\Search;
  use Illuminate\Database\Eloquent\Model;
  use Storage;

  /**
 * App\Team
 *
 * @property int $id
 * @property string $name
 * @property string $profile_image
 * @property string $designation
 * @property string $achievement_text
 * @property string $achievement_icon
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Team active()
 * @method static \Illuminate\Database\Eloquent\Builder|Team default()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|Team ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|Team ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereAchievementIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereAchievementText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Team extends Model
  {
    use CommonRelations, CommonScopes, Search;
    public function scopeOfProject($q, $column){
      return $q->where($column, Constant::ACTIVE);
    }
  }
