<?php

namespace App\Stripe;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Stripe\StripePlan
 *
 * @property int $id
 * @property int $stripe_product_id
 * @property string $stripe_id
 * @property string|null $object
 * @property int $active
 * @property string|null $aggregate_usage
 * @property float $amount
 * @property string|null $amount_decimal
 * @property string|null $billing_scheme
 * @property string|null $currency
 * @property string|null $interval
 * @property int|null $interval_count
 * @property int $livemode
 * @property string|null $nickname
 * @property string|null $product
 * @property string|null $usage_type
 * @property int|null $trial_period_days
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereAggregateUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereAmountDecimal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereBillingScheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereIntervalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereLivemode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereStripeProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereTrialPeriodDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stripe\StripePlan whereUsageType($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|StripePlan active()
 * @method static \Illuminate\Database\Eloquent\Builder|StripePlan default()
 * @method static \Illuminate\Database\Eloquent\Builder|StripePlan ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|StripePlan ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|StripePlan ofUser($userID)
 */
class StripePlan extends Model
{
    use CommonRelations, CommonScopes, Search;
}
