<?php


  namespace App\Pipes;


  use App\Contracts\PagePipeInterface;
  use App\Page;
  use App\Utils\Constants\Constant;
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  class PageScopePipe implements PagePipeInterface
  {
    /**
     * @param Builder $page
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $page, Closure $next)
    {
      $page->active()->provider(request('provider', Constant::HGP));
      
      return $next($page);
    }
  }
