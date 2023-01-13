<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Mail\GX\GXRegistrationConfirmationEmail;
use App\Mail\RegistrationConfirmationEmail;
use App\Mail\VerifyAccount;
use App\Mail\Welcome;
use App\Models\ResetPassword;
use App\Models\VerifyUser;
use App\Repositories\Cart\MergeCartRepository;
use App\Role;
use App\User;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mail;
use Str;
use Validator;

class AuthController extends Controller
{
    private $sessionID = null;
    private $provider = null;

    public function __construct()
    {
        Helper::initBraintree();
        if (Auth::user()) {
            $this->provider = Auth::user()->provider;
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.exists' => 'User Doesn\'t Exist'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Errors',
                'errors' => $validator->errors()->all()
            ], 401);
        }

        $credentials = $request->only('email', 'password');

        $user = User::with('assigned')->customer()->active()->whereEmail($request->email)->first();

        if (Helper::empty($user)) {
            return response()->json(['status' => false, 'message' => 'Invalid email or password.'], 400);
        }

        if ($user && !$user->status) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password.',
                'errors' => ['This user is inactive.']
            ], 401);
        }
        $serverSessionID = uniqid();
        if ($token = Auth::guard('api')->attempt($credentials)) {
            $cartID = MergeCartRepository::afterLogin($user, $serverSessionID, function ($sessionID) {
                $this->sessionID = $sessionID;
            });
            return $this->respondWithToken($token, $user, Cart::findCartById($cartID), $cartID);
        }

        return response()->json(['status' => false, 'message' => 'Invalid email or password.'], 400);
    }

    /**
     * Register Api
     **/
    public function register(Request $request)
    {
        $rules = [
            "firstName" => "required",
            "lastName" => "required",
            "email" => "required",
            "password" => "required",
            "password_confirmation" => "required",
            "phone" => "required"
        ];

        try {
            $this->validate($request, $rules, []);
        } catch (ValidationException $e) {
            return ApiResponse::validation($e->errors());
        }
        if ($request->password != $request->password_confirmation) {
            return errorResponse(__('Pasword & Confirm Password does not matched'));
        }
        try {
            $user = User::whereEmail($request->email)->first();
            if ($user) {
                return errorResponse(__('This email is already registered.'));
            }
            $user = new User();
            $user->role_id = Role::NORMAL_USER_ROLE;
            $user->name = $request->firstName . ' ' . $request->lastName;
            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->phone_number = $request->phone;
            $user->provider = $request->provider ?? Constant::HGP;
            $user->state = $request->state ?? null;
            $user->status = 0; //inactive by default
            $user->save();

            $token = sha1(time());

            VerifyUser::create([
                'email' => $user->email,
                'token' => $token
            ]);
            Mail::to($request->email)
                ->send(new VerifyAccount($user, $token, $user->provider));

            return successResponse(__('generic.user_registered'));

        } catch (Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());
        }
    }

    /**
     * braintree Payment Api Check
     **/
    public function braintreePaymentCheck(Request $request)
    {
        try {
            $user = User::where('id', '=', '104')->first();
            $response = Helper::addCustomerToBrainTree($user);
            return successResponse(__('User registered successfully.'), $response);
        } catch (Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());
        }

    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token, $user, $cart,$cartID)
    {
        return response()->json([
            'status' => true,
            '$cartID' => $cartID,
            'message' => 'Logged In Successfully',
            'cart' => $cart,
            'result' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => $user,
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ]
        ]);
    }

    /*change logged in user password*/
    public function changePassword(Request $request)
    {
        $rules = [
            'old' => 'required',
            'password' => 'required|same:password_confirmation|min:6',
            'password_confirmation' => 'required_with:password_confirmation|min:6',
        ];
        $messages = [
            'old.required' => __('validation.required'),
            'password.required' => __('validation.required'),
            'password.min' => __('validation.min.string'),
            'password.same' => __('validation.same'),
            'password_confirmation.min' => __('validation.min.string'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return errorResponse(__('generic.validation_errors'), $validator->errors()->all());
        }

        try {
            $user = User::active()->findOrFail(Auth::user()->id);
            if (Hash::check($request->old, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return successResponse(__('passwords.successfully_password_changed'));
            } else {
                return errorResponse(__("passwords.current_password_is_invalid"));

            }

        } catch (Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());

        }
    }

    /* Forgot Password
    * Send an email to user with a link
    *
    * */

    function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email'
        ], [
            'email.exists' => 'Email doesn\'t exist.'
        ]);

        if ($validator->fails()) {
            return errorResponse(__('generic.validation_errors'), $validator->errors()->all(), 422);
        }

        Helper::resetPassword($request->input('email'));

        if ($request->acceptsJson()) {
            return successResponse(__('generic.forgot_email_sent'));
        }

    }

    /* Reset Password
     * Via Valid Token
     *
     * */
    function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:new_password|min:6|same:password'
        ]);

        if ($validator->fails()) {
            return errorResponse(__('generic.validation_errors'), $validator->errors()->all());
        }

        $isValidToken = ResetPassword::isLinkValid($request->token);

        if (!$isValidToken) {
            return errorResponse(__('generic.token_expired'));
        }

        try {
            $password = bcrypt($request->input('password'));

            $user = User::where('email', $isValidToken->email)->first();

            if (! is_null($user)) {
                Mail::to($user->email)
                    ->send(new RegistrationConfirmationEmail($user->first_name,
                        null, $user->provider));
                Mail::to($user->email)
                    ->send(new Welcome($user->firstName . ' ' . $user->last_ame,
                        $user->first_name, null, $user->provider));
            }

            $user->update([
                'password' => $password
            ]);

            $token = DB::table('password_resets')->whereToken($request->token)->first();
            DB::table('password_resets')->where('email', $isValidToken->email)->delete();

            if ($token->type === 'new') {
                return successResponse('Your password has been set successfully.');
            } else {
                return successResponse(__('generic.password_changed'));
            }

        } catch (Exception $ex) {
            return errorResponse(__('generic.error'));
        }

    }


    /* Valid Link
    *
    * */
    function validateResetToken($token)
    {
        $isValid = ResetPassword::isLinkValid($token);

        if (!$isValid)
            return errorResponse('Link is expired or invalid');
        else
            return successResponse('Link is valid');
    }


    /* Get Logged In User Detail
     *
     * */
    public function getLoggedInUserDetail()
    {
        try {
            return ApiResponse::successResponse(__('generic.user_data'), Auth::user());
        } catch (Exception $e) {
            return ApiResponse::errorResponse(__('generic.error'), $e->getMessage());
        }
    }

    public function verifyAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return errorResponse(__('generic.validation_errors'), $validator->errors()->all());
        }

        try {
            $data = VerifyUser::whereToken($request->token)->whereEmail($request->email);
            if (!$data->exists()) {
                throw new Exception(__('generic.account_not_verified'));
            }
            $data->delete(); // Delete verification data

            User::whereEmail($request->email)->update(['status' => 1]);
            $user = User::whereEmail($request->email)->first();

            Mail::to($user->email)->send(new RegistrationConfirmationEmail($user->first_name, null, $user->provider));

            Mail::to($user->email)->send(new Welcome($user->first_name . ' ' . $user->last_name, $user->first_name, null, $user->provider));

            return successResponse(__('generic.account_verified'));

        } catch (\Exception $ex) {
            return errorResponse(__('generic.validation_errors'), $ex->getMessage());
        }
    }
}
