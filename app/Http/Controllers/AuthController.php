<?php

  namespace App\Http\Controllers;

  use App\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Validator;
  use Tymon\JWTAuth\Exceptions\JWTException;
  use Tymon\JWTAuth\Facades\JWTAuth;

  class AuthController extends Controller
  {
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
      dd('test');
      $validator = Validator::make($request->all(), [
        'email'     => 'required|exists:users,email',
        'password'  => 'required'
      ], [
        'email.exists' => 'User doesn\'t exists'
      ]);

      if($validator->fails()) {
        return response()->json([
          'status' => false,
          'message'    => 'Validation Errors',
          'errors'    => $validator->errors()->all()
        ],401);
      }

      $credentials = $request->only('email', 'password');

      $user = User::whereEmail($request->email)->first();

      if($user && !$user->status)
      {
        return response()->json([
          'status' => false,
          'message'    => 'Validation Errors',
          'errors'    => ['This user is inactive.']
        ],401);
      }

      if ($token = Auth::guard('api')->attempt($credentials)) {
        return $this->respondWithToken($token);
      }

      return response()->json(['status' => false, 'error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
      return response()->json(Auth::guard('api')->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
      Auth::guard('api')->logout();

      return response()->json([ 'status' => true, 'message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
      return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
      return response()->json([
        'status'    => true,
        'message'   => 'Logged In Successfully',
        'result'    => [
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]
      ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
      return Auth::guard();
    }
  }
