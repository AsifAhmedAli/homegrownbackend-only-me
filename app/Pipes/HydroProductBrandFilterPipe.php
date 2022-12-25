<?php
  
  
  namespace App\Pipes;
  
  
  use App\Contracts\HydroProductPipeInterface;
  use App\Utils\Helpers\Helper;
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  class HydroProductBrandFilterPipe implements HydroProductPipeInterface
  {
    /**
     * @param Builder $hydroProduct
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $hydroProduct, Closure $next)
    {
      $brands = explode(',', request('brands', ''));
      if(count($brands)) {
        if(!Helper::empty($brands[0])) {
          $brands = "'" . Helper::implode("','", $brands) . "'";
          $hydroProduct->whereRaw("hydro_products.recid in (select hydro_product_attributes.product_recid from hydro_product_attributes where hydro_product_attributes.attribute = 'Brand' and hydro_product_attributes.value in ({$brands}))");
        }
      }
      return $next($hydroProduct);
    }
  }
