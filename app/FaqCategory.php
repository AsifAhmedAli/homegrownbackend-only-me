<?php
  
  namespace App;
  
  use App\Utils\Traits\CommonRelations;
  use App\Utils\Traits\CommonScopes;
  use App\Utils\Traits\Search;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Database\Eloquent\Model;
  
  class FaqCategory extends Model
  {
    use CommonRelations, CommonScopes, Search;
    
    public function scopeActive(Builder $q)
    {
      $q->whereIsActive(true);
    }
    
    public function faqs() {
      return $this->hasMany(Faq::class, 'category_id', 'id');
    }
  }
