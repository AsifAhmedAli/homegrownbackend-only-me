<?php

namespace App;

use App\Utils\Constants\Constant;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ContactQuery
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactQuery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactQuery extends Model
{
    /*save contact us query*/
  public static function saveQuery($request) {
    $contact = new ContactQuery();
    $contact->provider = $request->provider ?? Constant::HGP;
    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->message = $request->message;
    return $contact->save();
  }
}
