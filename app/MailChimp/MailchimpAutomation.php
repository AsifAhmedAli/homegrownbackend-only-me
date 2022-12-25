<?php

namespace App\MailChimp;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * App\MailChimp\MailchimpAutomation
 *
 * @property int $id
 * @property string $user_id
 * @property string $cart_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation active()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation default()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpAutomation whereUserId($value)
 * @mixin \Eloquent
 */
class MailchimpAutomation extends Model
{
    use CommonRelations, CommonScopes, Search;
}
