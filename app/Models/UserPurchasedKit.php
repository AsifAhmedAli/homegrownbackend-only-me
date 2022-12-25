<?php

namespace App\Models;

use App\Kit;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class UserPurchasedKit extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $guarded = [];

    public function kit()
    {
        return $this->belongsTo(Kit::class, 'kit_id');
    }
}
