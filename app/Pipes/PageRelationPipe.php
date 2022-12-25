<?php
  
  
  namespace App\Pipes;
  use App\Contracts\PagePipeInterface;
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  class PageRelationPipe implements PagePipeInterface
  {
    /**
     * @param Builder $page
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $page, Closure $next)
    {
      $page->with([
        'section' => function ($q) {
          $q->whereIsActive(true);
        },
      ]);
  
      return $next($page);
    }
  }
