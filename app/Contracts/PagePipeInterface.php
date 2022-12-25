<?php
  
  
  namespace App\Contracts;
  
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  interface PagePipeInterface
  {
    public function handle(Builder $page, Closure $next);
  }
