<?php

namespace App\Models;

use App\Events\ChangeKitTrackingNumber;
use App\Kit;
use App\User;
use App\Utils\Helpers\Helper;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserKit extends Model
{
    use CommonRelations, CommonScopes, Search;

    public function kit(){
      return $this->belongsTo(Kit::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }


}
