<?php

namespace App\Http\Controllers\Voyager;

use App\Repositories\Report\CouponsReport;
use App\Repositories\Report\CustomerOrderReport;
use App\Repositories\Report\ReturningCustomerReport;
use App\Repositories\Report\SalesReport;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VoyagerReportsController extends VoyagerController
{
  /**
   * Array of available reports.
   *
   * @var array
   */
  private $reports = [
    'sales_report' => SalesReport::class,
    'coupons_report' => CouponsReport::class,
    'customers_order_report' => CustomerOrderReport::class,
    'returning_customer' => ReturningCustomerReport::class,
  ];
  
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function index(Request $request)
  {
    $type = $request->query('type', 'sales_report');
    if (! $this->reportTypeExists($type)) {
      return redirect()->route('admin.reports', ['type' => 'sales_report']);
    }
    
    return $this->report($type)->render($request);
  }
  
  /**
   * Determine if the report type exists.
   *
   * @param string $type
   * @return bool
   */
  private function reportTypeExists($type)
  {
    return array_key_exists($type, $this->reports);
  }
  
  /**
   * Returns a new instance of the given type of report.
   *
   * @param string $type
   * @return mixed
   */
  private function report($type)
  {
    return new $this->reports[$type];
  }
}
