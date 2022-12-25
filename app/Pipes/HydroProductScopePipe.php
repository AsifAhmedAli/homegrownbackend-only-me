<?php


  namespace App\Pipes;


  use App\Contracts\HydroProductPipeInterface;
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  class HydroProductScopePipe implements HydroProductPipeInterface
  {
    /**
     * @param Builder $hydroProduct
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $hydroProduct, Closure $next)
    {
      $hydroProduct->active()->default();

      return $next($hydroProduct);
    }
  }
