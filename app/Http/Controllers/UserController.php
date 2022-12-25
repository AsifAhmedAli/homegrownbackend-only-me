<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * Change Password in Admin Panel from Profile Logout section
     *
     * @return \Illuminate\Http\Response
     */

  public function changeAdminPassword(Request $request)
  {

    if ($request->has('submit')) {

      $validator = Validator::make($request->all(), [
        'current_password'      => 'required',
        'new_password'          => 'required_with:password_confirmation|same:password_confirmation|min:6',
        'password_confirmation' => 'min:6'
      ]);

      if ($validator->fails()) {
        return Redirect::back()->withErrors($validator->errors());
      }

      try {

        $user = User::find(Auth::user()->id);

        if (Hash::check($request->current_password, $user->password)) {
          $user->password = bcrypt($request->new_password);
          $user->save();

          return redirect()
            ->route("voyager.dashboard")
            ->with([
              'message'    => __('generic.successfully_password_changed'),
              'alert-type' => 'success',
            ]);
        } else {

          return redirect()->back()->with([
            'message'    => __('Current Password is invalid'),
            'alert-type' => 'error'
          ]);
        }

      } catch (\Exception $ex) {
        return redirect()->back()->with(['message' => __('generic.error'), 'alert-type' => 'error']);
      }

    }
    return view('admin.auth.change_password');
  }


  /* Forgot Password
* Send an email to user with a link
*
* */

  function forgot_password(Request $request)
  {
    $requestType = $request->getAcceptableContentTypes()[0];

    if ($request->has('submit') || $requestType == 'application/json') {
      $validator = Validator::make($request->all(), [
        'email' => 'required|exists:users,email'
      ], [
        'email.exists' => 'Email doesn\'t exists'
      ]);

      if ($validator->fails()) {
        if ($requestType == 'application/json') {
          return errorResponse(__('generic.validation_errors'), $validator->errors()->all());
        }
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }

        $token = Str::random(32);

        $user = User::where('email', $request->input('email'))->first();

        DB::table('password_resets')->insert([
          'email' => $request->input('email'),
          'token' => $token
        ]);

        $user->reset_token = $token;

        if ($requestType == 'application/json') {
          $user->link = env('WEB_URL') . '/reset-password/' . $user->reset_token;
        } else {
          $user->link = url('password/reset', $user->reset_token);
        }
        $settings = getSiteSettings();
        Mail::to($request->email)->send(new ForgotPassword($user, $settings));

        if ($requestType == 'application/json') {
          if ($request->acceptsJson()) {
            return successResponse(__('generic.forgot_email_sent'));
          }
        }

        return redirect('/admin/login')->with([
          'message'    => __('generic.forgot_email_sent'),
          'alert-type' => 'success',
        ]);
    }
    return view('admin.auth.forgot_password');
  }

  /* Show Reset Password
 * Validate Token Also
 * */

  function showResetForm($token)
  {

    $isValid = DB::table('password_resets')->where('token', $token)->first();

    $expired = $isValid ? false : true;

    return view('admin.auth.reset_password', compact('expired'));

  }

  /* Reset Password
 * Via Valid Token
 *
 * */
  function reset_password(Request $request)
  {
    $requestType = $request->getAcceptableContentTypes()[0];

    $validator = Validator::make($request->all(), [
      'token'                 => 'required',
      'password'              => 'bail|required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d).+$/|same:password_confirmation',
      'password_confirmation' => 'required_with:password'
    ], [
      'password.regex' => 'Password must contain at least one uppercase, one lowercase and a number'
    ]);

    if ($validator->fails()) {
      if ($requestType == 'application/json') {
        return errorResponse(__('generic.validation_errors'), $validator->errors()->all());
      }
      return Redirect::back()->withErrors($validator);
    }

    $isValidToken = DB::table('password_resets')->where('token', $request->input('token'))->first();
    
    if (!$isValidToken) {
      if ($requestType == 'application/json') {
        return errorResponse(__('generic.token_expired'));
      }
      return Redirect::back()->with([
        'message' => __('generic.token_expired'),
        'status'  => 'error'
      ]);
    }

    try {
      $password = bcrypt($request->input('password'));

      User::where('email', $isValidToken->email)->update([
        'password' => $password
      ]);
      

      DB::table('password_resets')->where('email', $isValidToken->email)->delete();

      if ($requestType == 'application/json') {
        return successResponse(__('generic.password_changed'));
      }
      
      $message = __('generic.password_changed');
      if($isValidToken->type === 'new') {
        $message = 'Your password has been set successfully.';
      }

      return Redirect::to('/admin/login')->with(['message' => $message, 'status' => 'success']);

    } catch (\Exception $ex) {
      if ($requestType == 'application/json') {
        return errorResponse(__('generic.error'));
      }

      return redirect()->back()->with(['message' => __('generic.error'), 'alert-type' => 'error']);

    }

  }
}
