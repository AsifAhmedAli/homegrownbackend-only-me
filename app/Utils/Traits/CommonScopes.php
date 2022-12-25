<?php


  namespace App\Utils\Traits;


  use App\Gx\Ticket;
  use App\Role;
  use App\User;
  use App\Utils\Constants\Constant;
  use App\Utils\Helpers\Helper;
  use Carbon\Carbon;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Support\Facades\DB;

  trait CommonScopes
  {
    /**
     * @param Builder $q
     * @param int $cartID
     */
    public function scopeOfCart(Builder $q, int $cartID)
    {
      $q->whereCartId($cartID);
    }

    /**
     * @param Builder $q
     * @param $userID
     */
    public function scopeOfUser(Builder $q, $userID)
    {
      $q->whereUserId($userID);
    }

    /**
     * @param Builder $q
     * @param int $productID
     */
    public function scopeOfProduct(Builder $q, int $productID)
    {
      $q->whereHydroProductId($productID);
    }

    public function scopeActive(Builder $q)
    {
      $q->whereIsActive(true);
    }

    public function scopeStatus(Builder $q, string $column, bool $value = true)
    {
      $q->where($column, $value);
    }

    public function scopeDefault($q)
    {
      $q->where('isDefault', true);
    }

    public function scopeProvider(Builder $builder, $provider = Constant::HGP)
    {
      $builder->whereProvider($provider);
    }

    public function scopeGx(Builder $builder)
    {
      $builder->whereProvider(Constant::GX);
    }

    public function scopeHgp(Builder $builder)
    {
      $builder->whereProvider(Constant::HGP);
    }

    public function scopeToMe(Builder $builder, $id = null)
    {
      if (in_array(auth()->user()->role_id, Role::growOperators())) {
        $builder->whereAssignedTo(auth()->id());
      } elseif ($id) {
        $builder->whereAssignedTo($id);
      }
    }

    public function scopeMyCustomerData(Builder $builder, $status = Constant::OPEN)
    {
      if(!Helper::isAdmin()) {
        $myCustomers = User::byMe()->pluck('id')->toArray();
        $builder->whereIn('user_id', $myCustomers);
       /* if($this instanceof Ticket) {
          $builder->whereStatus(Constant::OPEN);
        }*/
      }
    }

    public function scopeFilterByDate($query) {
        if(request()->has('start_date') && request()->filled('start_date') && request()->has('end_date') && request()->filled('end_date')) {
            $start_date = Carbon::parse(request()->get('start_date'))->format('Y-m-d');
            $end_date = Carbon::parse(request()->get('end_date'))->format('Y-m-d');
            $query->whereBetween(DB::raw('DATE(created_at)'), [
                $start_date,
                $end_date]);
        }
    }
  }
