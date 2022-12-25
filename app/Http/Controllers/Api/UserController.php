<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequestation;
use App\User;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use App\Utils\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  /*get logged in user */
  function getLoggedInUser() {
    $user = User::find(Auth::user()->id);
    return successResponse(__('generic.user_data'), $user);
  }

  /*change logged in user password*/
  function changePassword(Request $request)
  {
    $rules = [
      'current_password'  => 'required',
      'new_password' => 'required_with:password_confirmation|same:password_confirmation|min:6',
      'password_confirmation' => 'min:6'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return errorResponse(__('generic.validation_errors'), $validator->errors()->all());
    }

    if($request->current_password == $request->new_password) {
      return errorResponse(__('New Password Shouldn\'t Be Equal To Current Password.'));
    }

    try {
      $user = Auth::user();
      if (Hash::check($request->current_password, $user->password)) {
        $user->password = bcrypt($request->new_password);
        $user->save();

        return successResponse(__('generic.successfully_password_changed'));

      } else {

        return errorResponse(__('Current password is invalid.'));

      }

    } catch (\Exception $ex) {
      return errorResponse(__('generic.error'), $ex->getMessage());

    }
  }

  /*check email exists*/
  function checkEmail(Request $request) {
    $email = $request->email;
    $isAlreadyExist = User::whereEmail($email)->first();

    if($isAlreadyExist) {
      return errorResponse('Email already exist.', [], 422);
    } else {
      return successResponse('Email is available.');
    }
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return  successResponse('List of users.', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = [
        'name' => 'required',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:8',
      ];

      try {
        $this->validate($request, $rules);
      } catch (ValidationException $e) {
        return response()->json($e->errors(), 422);
      }
      $action = User::saveUser($request);
        if ($action) {
          return successResponse('User registered successfuly.');
        } else {
          return errorResponse();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        return successResponse('User Info.', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = User::find($id);
      return successResponse('User Info.', $data);
    }


    public function updateProfile(Request $request, $userId) {
        $rules = ValidationRule::updateUserProfile();
        $messages = ValidationMessage::updateUserProfile();
        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return ApiResponse::validation($e->errors());
        }
        try {
            if($request->has('avatar') && $request->filled('avatar')) {
                $user = User::find($userId);
                $avatar = ApiHelper::uploadBase64Image($request->avatar, 'users', $user->avatar);
                $request->merge(['avatar' => $avatar]);
            }
            $isUpdated = User::updateProfile($request, $userId);
            if ($isUpdated) {
                return ApiResponse::successResponse(__('generic.user_profile_updated'));
            }
            return ApiResponse::errorResponse(__('generic.user_profile_not_updated'));
        } catch (\Exception $ex) {
            return ApiResponse::errorResponse(__('generic.error'), $ex->getMessage());
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
          $user->delete();
          return successResponse('User deleted successfully.');
        } else {
          return errorResponse('User Not Exist.');
        }
    }
}
