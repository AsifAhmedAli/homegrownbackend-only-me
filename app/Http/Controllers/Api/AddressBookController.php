<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\AddressBook;
use App\Utils\Api\ApiHelper;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressBookController extends Controller
{
    protected $addressBook;

    public function __construct(AddressBook $addressBook)
    {
        parent::__construct();
        $this->addressBook = $addressBook;
    }

    public function store(Request $request)
    {
        $rules = ValidationRule::storeAAddressBook();
        $messages = ValidationMessage::storeAddressBook();
        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return errorResponse(__('generic.validation_errors'), $e->errors());
        }
        try {
            $userId = Auth::user()->id;
            $isSaved = $this->addressBook::store($request, $userId);
            if ($isSaved) {
                return successResponse(__('generic.address_saved'));
            }
            return errorResponse(__('generic.error'));
        } catch (\Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());
        }
    }

    public function getAddressById($addressId)
    {
        $address = $this->addressBook->find($addressId);
        if ($address) {
            return successResponse(__('generic.address_book'), $address);
        } else {
            return errorResponse(__('generic.error'));
        }

    }

    public function getAllDefaultAddresses()
    {
        try {
            $loggedInUserId = Auth::user()->id;
            $billing_address = $this->addressBook->where('default_billing', 1)->whereUserId($loggedInUserId)->first();
            $shipping = $this->addressBook->where('default_shipping', 1)->whereUserId($loggedInUserId)->first();

            $data = [
                'billing_address' => $billing_address,
                'shipping_address' => $shipping
            ];
            return successResponse(__('generic.default_address'), $data);
        } catch (\Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());
        }
    }

    public function allAddressBook()
    {
        try {
            $loggedInUserId = Auth::user()->id;
            if (ApiHelper::isHGP()){
              $query = $this->addressBook->ofProject(Constant::HGP);
            }else {
              $query = $this->addressBook->ofProject(Constant::GX);
            }
            $addresses = $query->whereUserId($loggedInUserId)->latest()->get();
            if (count($addresses)) {
                return successResponse(__('generic.address_book'), $addresses);
            } else {
                return errorResponse(__('generic.no_record'));
            }
        } catch (\Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());
        }

    }
    public function allAddressGXBook()
    {
        try {
            $loggedInUserId = Auth::user()->id;
            $addresses = $this->addressBook->ofProject(Constant::GX)->whereUserId($loggedInUserId)->latest()->get();
            if (count($addresses)) {
                return successResponse(__('generic.address_book'), $addresses);
            } else {
                return errorResponse(__('generic.no_record'));
            }
        } catch (\Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        $rules = ValidationRule::storeAAddressBook([], $id);
        $messages = ValidationMessage::storeAddressBook();
        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return errorResponse(__('generic.validation_errors'), $e->errors());
        }

        $isUpdated = AddressBook::updatedAddressBook($request, $id);
        if ($isUpdated) {
            return successResponse(__('generic.address_updated'));
        } else {
            return errorResponse(__('generic.no_record'));
        }
    }
    public function markAddressDefault(Request $request)
    {
        $isUpdated = AddressBook::markAddressDefault($request);
        if ($isUpdated) {
            return successResponse(__('generic.address_updated'));
        } else {
            return errorResponse(__('generic.no_record'));
        }
    }

    public function deleteAddressById($addressId)
    {
        $address = $this->addressBook->find($addressId);
        if ($address) {
            $address->delete();
            return successResponse(__('generic.address_deleted'));
        } else {
            return errorResponse(__('generic.no_record'));
        }

    }

    public function getAddressBooks()
    {
        $books = $this->addressBookBaseQuery();

        if ($books->count()) {
            $response['books']          = $books->orderBy('id', 'desc')->get();
            $code                        = 200;
        } else {
            $code                = 400;
            $response['message'] = null;
        }

        return response()->json($response, $code);
    }

    private function addressBookBaseQuery()
    {
        if(request()->has('type') && request()->get('type') == 'all') {
            return $this->addressBook->whereUserId(Auth::id());
        } else {
            return $this->addressBook->whereUserId(Auth::id())->whereProvider(request()->get('type'));
        }
    }
}
