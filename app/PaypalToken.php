<?php
  
  namespace App;
  
  use App\Utils\Traits\CommonRelations;
  use App\Utils\Traits\CommonScopes;
  use App\Utils\Traits\Search;
  use Illuminate\Database\Eloquent\Model;
  
  class PaypalToken extends Model
  {
    use CommonRelations, CommonScopes, Search;
    
    public static function current(string $env)
    {
      return static::where('env', $env)->latest('id')->first();
    }
  }
