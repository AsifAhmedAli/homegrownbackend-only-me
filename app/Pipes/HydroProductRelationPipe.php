<?php


namespace App\Pipes;


use App\Contracts\HydroProductPipeInterface;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HydroProductRelationPipe implements HydroProductPipeInterface
{
    /**
     * @param Builder $hydroProduct
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $hydroProduct, Closure $next)
    {
        $hydroProduct->with([
            'image' => function (HasOne $q) {
                $q->select('product_recid', 'url');
            },
            'price' => function (HasOne $q) {
                $q->select('product_recid', 'retailPrice');
            }
        ])->withCount([
            'isFavorite' => function ($q) {
                $q->whereUserId(\Auth::guard('api')->id());
            }
        ]);

        return $next($hydroProduct);
    }
}
