<?php

namespace App\Stripe;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Stripe\StripeProduct
 *
 * @property int $id
 * @property string $stripe_id
 * @property string|null $name
 * @property string|null $object
 * @property int $active
 * @property string|null $attributes
 * @property string|null $description
 * @property string|null $images
 * @property int|null $livemode
 * @property string|null $statement_descriptor
 * @property string|null $type
 * @property string|null $unit_label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereLivemode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereStatementDescriptor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereUnitLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripeProduct findOrFail(int $productID)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|StripeProduct active()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeProduct default()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeProduct ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeProduct ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeProduct ofUser($userID)
 */
class StripeProduct extends Model
{
    use CommonRelations, CommonScopes, Search;
}
