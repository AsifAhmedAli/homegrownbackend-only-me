<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use TCG\Voyager\Actions\DeleteAction;
use TCG\Voyager\Actions\RestoreAction;

/**
 * App\HydroBrand
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand default()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand query()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $show_in_menu
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand menu()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroBrand whereShowInMenu($value)
 */
class HydroBrand extends Model
{
    use CommonRelations, CommonScopes, Search;
  
    public const EXCLUDE_ACTIONS = [DeleteAction::class, RestoreAction::class];
    public const SHOW_BULK_CHECKBOX = false;
    public const CAN_ADD_NEW = false;
    public const CAN_BULK_DELETE = false;
    
    public function scopeMenu($q)
    {
      $q->whereShowInMenu(true);
    }
}
