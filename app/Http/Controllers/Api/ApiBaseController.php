<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Hydro\HydroProduct;
use App\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ApiBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $userID;

    /**
     * ApiBaseController constructor.
     */
    public function __construct()
    {
        try {
            $this->userID = $this->auth()->id();
        } catch (Exception $e) {
            $this->userID = null;
        }
        $this->userID = is_null($this->userID) ? 0 : $this->userID;
    }

    /**
     * @return Guard|StatefulGuard
     */
    protected function auth()
    {
        return auth()->guard('api');
    }

    /**
     * @return int|string|null
     */
    protected function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return Authenticatable|null|User
     */
    protected function getUser()
    {
        if ($this->userID) {
            return User::with('assigned')->whereId($this->userID)->first();
        } else {
            return null;
        }
    }

    /**
     * @param string $sku
     * @return HydroProduct
     */
    protected function getProduct(string $sku): HydroProduct
    {
        return HydroProduct::whereSku($sku)->firstOrFail();
    }

    /**
     * @param int $productID
     * @return HydroProduct
     */
    protected function findProductByID(int $productID): HydroProduct
    {
        return HydroProduct::findOrFail($productID);
    }
}
