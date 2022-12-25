<?php

namespace App\Gx;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use CommonRelations, CommonScopes, Search;
    
    protected $appends = ['created_ago', 'attachments_json'];
    
    protected $touches = ['ticket'];
    
    public function ticket()
    {
      return $this->belongsTo(Ticket::class);
    }
    
    public function getCreatedAgoAttribute()
    {
      return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
  
    public function getAttachmentsJsonAttribute()
    {
      return json_decode($this->attributes['attachments'] ?? '[]');
    }
}
