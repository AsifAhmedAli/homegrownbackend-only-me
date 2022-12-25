<?php
  
  
  namespace App\Repositories\Report;
  
  
  use App\Order;
  use Carbon\Carbon;

  class ReturningCustomerReport extends BaseReport
  {
    protected $date = 'orders.created_at';
    
    protected function view()
    {
      return 'voyager::reports.returning_customer';
    }
  
    protected function query()
    {
      return Order::select(\DB::raw('COUNT(customer_id) as customer_count'), 'customer_id', 'created_at', \DB::raw('DATE_FORMAT(created_at, "%b") as month'), \DB::raw('DATE(created_at) as monthly'))
        //                ->groupBy(\DB::raw('MONTH(created_at)'))
        ->groupBy('customer_id')
        ->having('customer_count', '>', 1);
    }
  
    public static function getOnceCustomerOrdered() {
    
      $query = Order::select(\DB::raw('COUNT(customer_id) as customer_count'), 'created_at', \DB::raw('DATE_FORMAT(created_at, "%b") as month'),  \DB::raw('DATE(created_at) as monthly'))
        //            ->groupByRaw('MONTH(created_at)')
        ->groupByRaw('customer_id')
        ->having('customer_count', '=', 1);
    
      if(request()->has('from') && request()->has('to')) {
        $query = $query->whereDate('created_at', '>=', Carbon::parse(request()->get('from')));
        $query = $query->whereDate('created_at', '<=', Carbon::parse(request()->get('to')));
      }
  
      return $query->orderBy('orders.id', 'desc')->get();
    }
  }
