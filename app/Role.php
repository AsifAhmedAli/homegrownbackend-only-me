<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use TCG\Voyager\Models\Role as VoyagerRole;

class Role extends VoyagerRole
{
    use CommonRelations, CommonScopes, Search;
    
    public const DEVELOPER_ROLE = 1;
    public const ADMIN_ROLE = 2;
    public const NORMAL_USER_ROLE = 3;
    public const RETAILER_ROLE = 4;
    public const GROW_MASTER_ROLE = 5;
    public const GROW_PRO_ROLE = 6;
    public const GROW_TECH_ROLE = 7;
    
    public static function mainAdminRoles()
    {
      return [self::ADMIN_ROLE, self::DEVELOPER_ROLE];
    }
    
    public static function adminRoles()
    {
      return array_merge(self::mainAdminRoles(), [self::GROW_MASTER_ROLE, self::GROW_PRO_ROLE, self::GROW_TECH_ROLE]);
    }
    
    public static function growOperators()
    {
      return [self::GROW_MASTER_ROLE];
//      return [self::GROW_MASTER_ROLE, self::GROW_PRO_ROLE, self::GROW_TECH_ROLE];
    }
    
    public function scopeRoles(Builder $q)
    {
      $q->whereIn('id', self::adminRoles());
    }
}
