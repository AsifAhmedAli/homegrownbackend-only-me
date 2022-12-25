<?php

namespace App\Models\GX;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use function GuzzleHttp\Psr7\str;

class GXHomePage extends Model
{
    protected  $table = 'gx_home_page';
    use CommonRelations, CommonScopes, Search;
  public function scopeActive(Builder $q)
  {
    $q->whereIsActive(true);
  }
  
  public function setVideoSection1CtaUrlAttribute($videoSection1URL)
  {
    $this->attributes['video_section_1_cta_url']  = $this->attachAutoPlayToURL($videoSection1URL);
  }
  
  public function setVideoSection2CtaUrlAttribute($videoSection1URL)
  {
    $this->attributes['video_section_2_cta_url']  = $this->attachAutoPlayToURL($videoSection1URL);
  }
  private function attachAutoPlayToURL($videoURL) {
    $urlWithQueryParam = $videoURL;
    if (strpos($videoURL, "autoplay")){
      $urlWithQueryParam = $videoURL;
    }
    else if (strpos($videoURL, '?')){
      $urlWithQueryParam  = $videoURL."&autoplay=1";
    }else {
      $urlWithQueryParam = $videoURL.'?autoplay=1';
    }
    return $urlWithQueryParam;
  }
}
