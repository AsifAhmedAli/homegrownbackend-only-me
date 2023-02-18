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
      if($cart != NULL){
        $response1['tax_value'] = 0;
        if(isset($cart-> shipping_address_state)){
          switch ($cart-> shipping_address_state) {
            case 'AL':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'AK':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'AZ':
              $tax1 = 5.6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'AR':
              $tax1 = 6.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'CA':
              $tax1 = 7.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'CO':
              $tax1 = 2.9;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'CT':
              $tax1 = 6.35;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'DE':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'DC':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'FL':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'GA':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'HI':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'ID':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'IL':
              $tax1 = 6.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'IN':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'IA':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'KS':
              $tax1 = 6.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'KY':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'LA':
              $tax1 = 4.45;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'ME':
              $tax1 = 5.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MD':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MA':
              $tax1 = 6.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MI':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MN':
              $tax1 = 6.88;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MS':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MO':
              $tax1 = 4.23;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'MT':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NE':
              $tax1 = 5.5;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NV':
              $tax1 = 6.85;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NH':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NJ':
              $tax1 = 6.63;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NM':
              $tax1 = 5.13;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NY':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NC':
              $tax1 = 4.75;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'ND':
              $tax1 = 5;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'OH':
              $tax1 = 5.75;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'OK':
              $tax1 = 4.5;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'OR':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'PA':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'RI':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'SC':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'SD':
              $tax1 = 4.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'TN':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'TX':
              $tax1 = 6.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'UT':
              $tax1 = 5.95;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'VT':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'VA':
              $tax1 = 5.3;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WA':
              // $cart->tax = 6.5;
              $tax1 = 6.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WV':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WI':
              $tax1 = 5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WY':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
          }
        }
        else{
          switch ($cart-> billing_address_state) {
            case 'AL':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'AK':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'AZ':
              $tax1 = 5.6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'AR':
              $tax1 = 6.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'CA':
              $tax1 = 7.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'CO':
              $tax1 = 2.9;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'CT':
              $tax1 = 6.35;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'DE':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'DC':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'FL':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'GA':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'HI':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'ID':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'IL':
              $tax1 = 6.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'IN':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'IA':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'KS':
              $tax1 = 6.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'KY':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'LA':
              $tax1 = 4.45;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'ME':
              $tax1 = 5.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MD':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MA':
              $tax1 = 6.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MI':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MN':
              $tax1 = 6.88;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MS':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'MO':
              $tax1 = 4.23;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'MT':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NE':
              $tax1 = 5.5;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NV':
              $tax1 = 6.85;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NH':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NJ':
              $tax1 = 6.63;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NM':
              $tax1 = 5.13;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NY':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'NC':
              $tax1 = 4.75;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'ND':
              $tax1 = 5;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'OH':
              $tax1 = 5.75;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'OK':
              $tax1 = 4.5;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'OR':
              $tax1 = 0;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'PA':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
    
            case 'RI':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'SC':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'SD':
              $tax1 = 4.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'TN':
              $tax1 = 7;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'TX':
              $tax1 = 6.25;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'UT':
              $tax1 = 5.95;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'VT':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'VA':
              $tax1 = 5.3;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WA':
              // $cart->tax = 6.5;
              $tax1 = 6.5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WV':
              $tax1 = 6;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WI':
              $tax1 = 5;
              $response1['tax_value'] = $tax1."%";
            break;
            case 'WY':
              $tax1 = 4;
              $response1['tax_value'] = $tax1."%";
            break;
          }
        }
      }
      else{
        $response1['tax_value'] = 0;
      }

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
        'tax_value' => $response1['tax_value']
      ]);
    }

    public function legalStates()
    {
      $response['states'] = State::select('name', 'iso2 as abbreviation')->legal()->get();

      return ApiResponse::success($response);
    }
}
