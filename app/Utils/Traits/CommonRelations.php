<?php
  
  
  namespace App\Utils\Traits;
  
  
  use App\User;

  trait CommonRelations
  {
    public function assignee()
    {
      return $this->belongsTo(User::class, 'assigned_to');
    }
    
    public function user()
    {
      return $this->belongsTo(User::class);
    }
  }
