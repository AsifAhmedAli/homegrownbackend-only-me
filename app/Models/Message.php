<?php

namespace App\Models;

use App\User;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $with = [
        'attachments', 'senderUser', 'receiverUser'
    ];

    public function senderUser() {
        return $this->belongsTo(User::class, 'sender');
    }

    public function receiverUser() {
        return $this->belongsTo(User::class, 'receiver');
    }

    public function attachments() {
        return $this->hasMany(MessageAttachment::class);
    }

    public static function myMessages() {

        return Message::whereSender(auth()->id())
                            ->orWhere('receiver', auth()->id())
                            ->get();
    }

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }
}
