<?php

namespace App\Gx;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use CommonRelations, CommonScopes, Search;
    
    public function messages()
    {
      return $this->hasMany(TicketMessage::class)->orderBy('id', 'desc');
    }
    
    public function last_message()
    {
      return $this->hasOne(TicketMessage::class)->latest('id');
    }
    
    public function getTicketNumberAttribute()
    {
      return 'GX' . str_pad($this->attributes['id'], 6, "0", STR_PAD_LEFT);
    }
}
