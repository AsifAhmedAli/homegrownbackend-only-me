<?php
  
  
  namespace App\Repositories\Report;
  
  
  use App\Order;

  class CustomerOrderReport extends BaseReport
  {
    protected $date = 'orders.created_at';
    protected function view()
    {
      return 'voyager::reports.customer_order_report';
    }
  
    protected function query()
    {
      return Order::select('customer_id', 'customer_first_name', 'customer_last_name', 'customer_email')
        ->selectRaw('MIN(orders.created_at) as start_date')
        ->selectRaw('MAX(orders.created_at) as end_date')
        ->selectRaw('COUNT(*) as total_orders')
        ->join('order_products', 'orders.id', '=', 'order_products.order_id')
        ->selectRaw('SUM(order_products.qty) as total_products')
        ->selectRaw('SUM(orders.total) as total')
        ->when(request('customer_name'), function ($query) {
          $query->whereRaw("CONCAT_WS(' ' , customer_first_name , customer_last_name) like ?" , ['%'.request('customer_name').'%']);
        })
        ->when(request('customer_email'), function ($query) {
          $query->where('customer_email', request('customer_email'));
        })
        ->groupBy([
          'orders.id',
          'customer_id',
          'customer_first_name',
          'customer_last_name',
          'customer_email',
        ])->orderBy('orders.id', 'desc');
    }
  }
