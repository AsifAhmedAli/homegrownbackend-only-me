<?php
  
  
  namespace App\Pipes;
  
  
  use App\Contracts\HydroProductPipeInterface;
  use App\Hydro\HydroCategory;
  use Closure;
  use Illuminate\Database\Eloquent\Builder;

  class HydroProductCategoryFilterPipe implements HydroProductPipeInterface
  {
    /**
     * @param Builder $hydroProduct
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $hydroProduct, Closure $next)
    {
      $categories = explode(',', request('categories'));
      $categoryIDs = $this->getCategories($categories);
      if(count($categoryIDs)) {
        $hydroProduct->whereIn('categoryid', $categoryIDs);
      }
      
      return $next($hydroProduct);
    }
  
    /**
     * @param array $categories
     * @return array
     */
    private function getCategories(array $categories): array
    {
      $hydroCategories = HydroCategory::whereIn('short_name', $categories)->active()->pluck('hydro_id')->toArray();
      $categories = $hydroCategories;
      $children = HydroCategory::whereIn('hydro_parent_id', $categories)->active()->pluck('hydro_id')->toArray();
      $categories = array_unique(array_merge($categories, $children));
      
      return $categories;
    }
  }
