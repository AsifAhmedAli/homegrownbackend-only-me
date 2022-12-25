<?php

namespace App\Models;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class ChatNotification extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $guarded = [];

    static function new() {
        return self::whereNotificationTo(auth()->id())->unSeen()->get();
    }

    function scopeUnSeen($query) {
        $query->whereSeen(0);
    }

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }
}
