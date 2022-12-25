<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Transaction
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $transaction_id
 * @property string|null $payment_method
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction active()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction default()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction ofUser($userID)
 * @method static \Illuminate\Database\Query\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Transaction withoutTrashed()
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use CommonRelations, CommonScopes, Search,SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     *
     * @param $orderId
     * @param $transactionId
     * @param string $paymentMethod
     */
    public static function saveTransaction($orderId, $transactionId, $paymentMethod = 'braintree') {
        $trans = new Transaction();
        $trans->order_id = $orderId;
        $trans->transaction_id = $transactionId;
        $trans->payment_method = $paymentMethod;
        $trans->save();
    }

}
