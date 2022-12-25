<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PageSection
 *
 * @property int $id
 * @property int $page_id
 * @property string|null $title
 * @property string|null $image
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageSection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageSection extends Model
{
    //
}
