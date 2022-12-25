<?php
  
  
  namespace App\Pipes;
  
  
  use App\Contracts\HydroProductPipeInterface;
  use App\Utils\Helpers\Helper;
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  class HydroProductSortPipe implements HydroProductPipeInterface
  {
    /**
     * @param Builder $hydroProduct
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $hydroProduct, Closure $next)
    {
      $sorting = Helper::resolveSorting(request('sort'));
      $column = Helper::arrayIndex($sorting, 'column');
      $sort = Helper::arrayIndex($sorting, 'sort');
      $hydroProduct->orderBy($column, $sort);
  
      return $next($hydroProduct);
    }
  }
