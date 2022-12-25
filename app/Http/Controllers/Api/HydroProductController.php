<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Hydro\HydroCategory;
use App\Hydro\HydroProduct;
use App\Hydro\HydroProductAttribute;
use App\Pipes\HydroProductCategoryFilterPipe;
use App\Pipes\HydroProductRelationPipe;
use App\Pipes\HydroProductScopePipe;
use App\Pipes\HydroProductSortPipe;
use App\Utils\Api\ApiResponse;
use App\Utils\Helpers\Helper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;

class HydroProductController extends Controller
{
    private $filterPipes = [
        HydroProductScopePipe::class,
        HydroProductRelationPipe::class,
        HydroProductCategoryFilterPipe::class,
//        HydroProductBrandFilterPipe::class,
        HydroProductSortPipe::class
    ];
    private $perPage = 12;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $products = HydroProduct::select('logo', 'featured_image',
            'hydro_products.id', 'hydro_products.recid', 'hydro_products.sku', 'hydro_products.name', 'hydro_products.categoryid', 'hydro_products.model', 'hydro_product_prices.retailPrice', 'hydro_products.issale', 'hydro_products.salestartdate', 'hydro_products.saleenddate'
        )->leftJoin('hydro_product_prices', 'hydro_products.recid', '=', 'hydro_product_prices.product_recid');

        app(Pipeline::class)
            ->send($products)
            ->through($this->filterPipes)
            ->thenReturn();


        $productIDs         = $products->pluck('recid')->toArray();
        $response['brands'] = $this->getBrands($productIDs);
      $brands               = explode(',', request('brands', ''));
      if (count($brands)) {
        if (!Helper::empty($brands[0])) {
          $brands        = "'" . Helper::implode("','", $brands) . "'";
          $productIDsStr = "'" . Helper::implode("','", $productIDs) . "'";
          $products->whereRaw("hydro_products.recid in (select hydro_product_attributes.product_recid from hydro_product_attributes where hydro_product_attributes.attribute = 'Brand' and hydro_product_attributes.value in ({$brands}) and hydro_product_attributes.product_recid in ({$productIDsStr}))");
        }
      }

      $response['counter']    = $products->count();
      $response['categories'] = HydroCategory::with(['children' => function ($q) {
        $q->whereIsActive(true);
      }])->select('id', 'name', 'short_name', 'hydro_id', 'hydro_parent_id')->active()->root()->get();
      $response['products']   = $products->paginate($this->perPage);

      return ApiResponse::success($response);
    }

    public function optimized()
    {
        $products = HydroProduct::select('logo', 'featured_image',
             'recid', 'sku'
        )
        /*->leftJoin('hydro_product_prices', 'hydro_products.recid', '=', 'hydro_product_prices.product_recid')*/;

            app(Pipeline::class)
                ->send($products)
                ->through($this->filterPipes)
                ->thenReturn();

        $productIDs         = $products->pluck('recid')->toArray();
        $response['brands'] = $this->getBrands($productIDs);
      $brands               = explode(',', request('brands', ''));
      if (count($brands)) {
        if (!Helper::empty($brands[0])) {
          $brands        = "'" . Helper::implode("','", $brands) . "'";
          $productIDsStr = "'" . Helper::implode("','", $productIDs) . "'";
          $products->whereRaw("hydro_products.recid in (select hydro_product_attributes.product_recid from hydro_product_attributes where hydro_product_attributes.attribute = 'Brand' and hydro_product_attributes.value in ({$brands}) and hydro_product_attributes.product_recid in ({$productIDsStr}))");
        }
      }

      $response['counter']    = $products->count();
      $response['products']   = $products->paginate($this->perPage);

      return ApiResponse::success($response);
    }

    public function getCategories() {
        $response['categories'] = HydroCategory::with(['childs' => function ($q) {
            $q->whereIsActive(true);
        }])->select('id', 'name', 'short_name', 'hydro_id')->active()->root()->get();
        return ApiResponse::success($response);
    }

    /**
     * @param array $productIDs
     * @return array
     */
    private function getBrands(array $productIDs): array
    {
        $brands = HydroProductAttribute::whereIn('product_recid', $productIDs)->where('attribute', 'Brand')->groupBy('value')->pluck('value')->toArray();

        $brandsArray = [];
        foreach ($brands as $brand) {
            if(!empty($brand)) {
                $obj = new \stdClass();
                $obj->name = $brand;
                $brandsArray[] = $obj;
            }
        }

        return $brandsArray;
    }

    public function find(string $sku)
    {
        $product = HydroProduct::select('recid', 'hydro_products.*', 'hydro_product_prices.retailPrice')
            ->leftJoin('hydro_product_prices', 'hydro_products.recid', '=', 'hydro_product_prices.product_recid')
            ->with([
                'brand:product_recid,attribute,value,dataType',
                'specifications:product_recid,attribute,value,dataType',
                'bar_codes:product_recid,barcode,barcodeType,uom',
                'dimensions:product_recid,uom,depth,height,weight,width',
                'documents:product_recid,url,docName',
                'images:product_recid,url,docName',
                'related' => function (HasMany $q) {
                    $q->select('product_recid', 'sku', 'relation')->continued()->limit(16);
                },
                'related.related' => function (BelongsTo $q) {
                    $q->select('hydro_products.id', 'hydro_products.recid', 'hydro_products.sku', 'hydro_products.name', 'hydro_products.categoryid', 'hydro_products.model')->withCount([
                      'isFavorite' => function ($q) {
                        $q->whereUserId(\Auth::guard('api')->id());
                      }
                    ]);
                },
                'category:hydro_id,name,short_name,hydro_parent_id',
                'category.parent:hydro_id,name,short_name,hydro_parent_id',
                'inventories',
                'family.items'
            ])->withCount([
            'isFavorite' => function ($q) {
              $q->whereUserId(\Auth::guard('api')->id());
            }
          ])->whereSku($sku)->active()->firstOrFail();

        $relatedProducts = [];

        foreach ($product->related as $related) {
          if(!Helper::empty(optional($related)->related)) {
            $relatedProducts[] = $related;
          }
        }

        $product->is_prop65_warning = $product->is_prop65_warning;
        $product->is_fcc = $product->is_fcc;
        $product->is_csa = $product->is_csa;
        $product->_related = $relatedProducts;

        $response['product'] = $product;

        return ApiResponse::success($response);
    }

}
