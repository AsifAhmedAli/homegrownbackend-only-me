<?php
  
  
  namespace App\Repositories\Report;
  
  
  use App\Coupon;

  class CouponsReport extends BaseReport
  {
    protected $date = 'orders.created_at';
    
    protected function view()
    {
      return 'voyager::reports.coupons';
    }
  
    protected function query()
    {
      return Coupon::select('coupons.id', 'code')
        ->join('orders', 'coupons.id', '=', 'orders.coupon_id')
        ->selectRaw('MIN(orders.created_at) as start_date')
        ->selectRaw('MAX(orders.created_at) as end_date')
        ->selectRaw('COUNT(*) as total_orders')
        ->selectRaw('SUM(orders.discount) as total')
        ->when(request('coupon_code'), function ($query) {
          $query->where('code', request('coupon_code'));
        })
        ->groupBy(['coupons.id', 'coupons.code'])->orderBy('orders.id', 'desc');
    }
  }
