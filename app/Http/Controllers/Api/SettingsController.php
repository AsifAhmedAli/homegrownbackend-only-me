<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Gx\LightingType;
use App\Gx\MediaType;
use App\Gx\Strain;
use App\Http\Controllers\Controller;
use App\Hydro\HydroCategory;
use App\Hydro\HydroProductAttribute;
use App\HydroBrand;
use App\Kit;
use App\Order;
use App\Page;
use App\Repositories\Hydro\HydroOrderRepository;
use App\State;
use App\Utils\Api\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Setting;

class SettingsController extends ApiBaseController
{
    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function index()
    {
      $provider = request('provider', 'hgp');
      $group = $provider == 'gx' ? 'gx' : 'site';
      $settings = Setting::where('group', $group)->get();
      $categories = HydroCategory::with([
        'children' => function(HasMany $q) {
          $q->menu()->active();
        }
      ])->menu()->root()->active()->get();

//      $brands = HydroBrand::active()->menu()->get();
      $attrBrands = HydroProductAttribute::where('attribute', 'Brand')->groupBy('value')->pluck('value')->toArray();
//
      $brands = [];
      foreach ($attrBrands as $brand) {
          if(!empty($brand)) {
              $obj = new \stdClass();
              $obj->name = $brand;
              $brands[] = $obj;
          }
      }
      $cart = Cart::findBySessionID(request('sessionID'));
      if($cart) {
        $cart = Cart::findCartById($cart->id);
      }
      
      $firstKit = Kit::active()->first();

      return ApiResponse::success([
        'cart' => $cart,
        'categories' => $categories,
        'brands' => $brands,
        'settings' => $settings,
        'lighting_types' => LightingType::get(),
        'strains' => Strain::get(),
        'media_types' => MediaType::get(),
        'user' => $this->getUser(),
        'firstKit' => $firstKit,
      ]);
    }

    public function legalStates()
    {
      $response['states'] = State::select('name', 'iso2 as abbreviation')->legal()->get();

      return ApiResponse::success($response);
    }
}
