<?php

namespace App\Models;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResetPassword extends Model
{
    use CommonRelations, CommonScopes, Search;

    public static function isLinkValid($code)
    {
      $resetToken = DB::table('password_resets')
        ->whereToken($code)->first();
      if($resetToken) {
        $isValidCode = DB::table('password_resets')
          ->whereToken($code)
          ->when($resetToken->type === 'reset', function($q) {
            $q->where('expired_at', '>=', today()->toDateTimeString());
          })
          ->first();
  
        if(!$isValidCode) {
          return false;
        }
  
        return $isValidCode;
      }
      
      return false;
    }
}
