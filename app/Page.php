<?php

namespace App;

use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Page
 *
 * @property int $id
 * @property int|null $author_id
 * @property string $title
 * @property string $slug
 * @property string|null $body
 * @property string|null $image
 * @property string $status
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PageSection[] $section
 * @property-read int|null $section_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|\App\Page active()
 * @method static Builder|\App\Page newModelQuery()
 * @method static Builder|\App\Page newQuery()
 * @method static Builder|\App\Page query()
 * @method static Builder|\App\Page whereAuthorId($value)
 * @method static Builder|\App\Page whereBody($value)
 * @method static Builder|\App\Page whereCreatedAt($value)
 * @method static Builder|\App\Page whereId($value)
 * @method static Builder|\App\Page whereImage($value)
 * @method static Builder|\App\Page whereMetaDescription($value)
 * @method static Builder|\App\Page whereMetaKeywords($value)
 * @method static Builder|\App\Page whereMetaTitle($value)
 * @method static Builder|\App\Page whereSlug($value)
 * @method static Builder|\App\Page whereStatus($value)
 * @method static Builder|\App\Page whereTitle($value)
 * @method static Builder|\App\Page whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static Builder|\App\Page whereUpdatedAt($value)
 * @method static Builder|\App\Page withTranslation($locale = null, $fallback = true)
 * @method static Builder|\App\Page withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 */
class Page extends Model
{
  use CommonScopes;
  
  
  protected $guarded = [];
  
  /*each page has many sections*/
  public function section()
  {
    return $this->hasMany('App\PageSection');
  }
  
  
  /**
   * Scope a query to only include active pages.
   *
   * @param  $query  Builder
   *
   * @return Builder
   */
  public function scopeActive($query)
  {
    return $query->whereIsActive(1);
  }
}
