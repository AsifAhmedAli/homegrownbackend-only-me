<?php

namespace App\Hydro;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use TCG\Voyager\Actions\DeleteAction;
use TCG\Voyager\Actions\RestoreAction;

/**
 * App\Hydro\HydroCategory
 *
 * @property int $id
 * @property int $hydro_id
 * @property int|null $hydro_parent_id
 * @property string $name
 * @property string|null $short_name
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory ofUser($userID)
 * @method static \Illuminate\Database\Query\Builder|HydroCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereHydroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereHydroParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|HydroCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|HydroCategory withoutTrashed()
 * @property int $is_root
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereIsRoot($value)
 * @property-read Collection|HydroCategory[] $children
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory root($query)
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroCategory active($query)
 * @property int $is_featured
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory default()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereIsFeatured($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory child()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory featured()
 * @property int $show_in_menu
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory menu()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroCategory whereShowInMenu($value)
 * @property-read HydroCategory|null $parent
 */

class HydroCategory extends Model
{
    use CommonRelations, CommonScopes, SoftDeletes;

    public const EXCLUDE_ACTIONS = [DeleteAction::class, RestoreAction::class];
    public const SHOW_BULK_CHECKBOX = false;
    public const CAN_ADD_NEW = false;
    public const CAN_BULK_DELETE = false;

    public function scopeRoot($q)
    {
      $q->whereIsRoot(true);
    }

    public function scopeChild($q)
    {
      $q->whereIsRoot(false);
    }
    public function scopeFeatured($q) {
      $q->whereIsFeatured(true);
    }

    public function scopeMenu($q)
    {
      $q->whereShowInMenu(true);
    }

    public function parent()
    {
      return $this->belongsTo(self::class, 'hydro_parent_id', 'hydro_id');
    }

    public function children()
    {
      return $this->hasMany(self::class, 'hydro_parent_id', 'hydro_id');
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'hydro_parent_id', 'hydro_id')->select('id', 'name', 'short_name', 'hydro_parent_id');
    }
}
