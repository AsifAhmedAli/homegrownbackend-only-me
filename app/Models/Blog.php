<?php

namespace App\Models;

use App\Utils\Constants\Constant;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Blog extends Model
{
  use CommonRelations, CommonScopes, Search, Searchable;
  
  protected $table = 'blogs';
  
  public function tags()
  {
    return $this->belongsTo(Tag::class);
  }
  
  //get blog sections
  public function sections()
  {
    return $this->hasMany(BlogSection::class);
  }
  
  public function searchableAs()
  {
    return 'searchable_items';
  }
  
  public function toSearchableArray()
  {
    
    if ($this->attributes['is_active']
        && $this->attributes['published_at'] <= Carbon::today()
        && $this->attributes['provider'] == Constant::HGP
    ) {
      return [
        'id'                => $this->attributes['id'],
        'sku'               => null,
        'slug'              => $this->attributes['slug'],
        'created_at'        => $this->attributes['created_at'],
        'name'              => $this->attributes['name'],
        'image'             => $this->attributes['thumbnail_image'],
        'price'             => null,
        'category'          => null,
        'brand'             => null,
        'type'              => "blog",
        'is_favorite_count' => 0,
      ];
    } else {
      [];
    };
  }
  
  public function scopeActiveAndPublish($q)
  {
    $q->whereIsActive(1)->published();
  }
  
  public function scopeActive($q)
  {
    $q->whereIsActive(1);
  }
  
  //published posts
  public function scopePublished(Builder $query)
  {
    $query->whereDate('published_at', '<=', Carbon::today());
  }
  
//  public function getPublishedAtAttribute()
//  {
//    return date('d M, Y', strtotime($this->attributes['published_at']));
//  }
}
