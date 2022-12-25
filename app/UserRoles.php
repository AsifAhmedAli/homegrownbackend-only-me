<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * App\UserRoles
 *
 * @property int $user_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles active()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles default()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles whereUserId($value)
 * @mixin \Eloquent
 */
class UserRoles extends Model
{
    use CommonRelations, CommonScopes, Search;
}
