<?php

namespace App\Models;

use App\Role;
use App\User;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $with = [
      'messages'
    ];

    public function customer() {
        return $this->belongsTo(User::class, 'chat_with');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function scopeMyChats($builder) {
        if (!in_array(auth()->user()->role_id, Role::mainAdminRoles())) {
            $builder->whereAssignedTo(auth()->id());
        }
    }

    public static function userChat() {

        return self::whereChatWith(auth()->id())->first();
    }
}
