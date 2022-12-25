<?php
  
  
  namespace App\Contracts;
  
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  interface HydroProductPipeInterface
  {
    public function handle(Builder $hydroProduct, Closure $next);
  }
