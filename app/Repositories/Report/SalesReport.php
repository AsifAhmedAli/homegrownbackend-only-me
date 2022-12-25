<?php
  
  
  namespace App\Repositories\Report;
  
  
  use App\Order;
  use DB;

  class SalesReport extends BaseReport
  {
    protected function view()
    {
      return 'voyager::reports.sales';
    }
  
    protected function query()
    {
      return Order::selectRaw('DATE(orders.created_at)')
        ->selectRaw('MIN(created_at) as start_date')
        ->selectRaw('MAX(created_at) as end_date')
        ->selectRaw('COUNT(*) as total_orders')
        ->join(DB::raw('(SELECT order_id, sum(qty) qty FROM order_products GROUP BY order_id) op'), function ($join) {
          $join->on('orders.id', '=', 'op.order_id');
        })
        ->selectRaw('SUM(op.qty) as total_products')
        ->selectRaw('SUM(sub_total) as sub_total')
        ->selectRaw('SUM(shipping_cost) as shipping_cost')
        ->selectRaw('SUM(discount) as discount')
        ->selectRaw('SUM(tax) as tax')
        ->selectRaw('SUM(orders.total) as total')
        ->groupByRaw('DATE(orders.created_at)')->orderBy('orders.id', 'desc');
    }
  }
