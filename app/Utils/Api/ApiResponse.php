<?php


namespace App\Utils\Api;


use App\Utils\Constants\Messages;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Helpers\Helper;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * @param string|array|null $response
     * @param int $code
     * @return JsonResponse
     */
    public static function failure($response, int $code = 400)
    {
        if (!is_array($response)) {
            $response = ['message' => $response];
        }
        return response()->json($response, $code);
    }

    /**
     * @param string|array|null $response
     * @param int $code
     * @return JsonResponse
     */
    public static function success($response, int $code = 200)
    {
        if (!is_array($response)) {
            $response = ['message' => $response];
        }
        return response()->json($response, $code);
    }

    /**
     * @return JsonResponse
     */
    public static function quantity()
    {
        return self::failure(Messages::QUANTITY_LIMIT);
    }

    /**
     * @param int $code
     * @param string $message
     * @return JsonResponse
     */
    public static function cart(int $code = 400, string $message = Messages::CART_NOT_FOUND)
    {
        return self::failure($message, $code);
    }

    /**
     * @param array $errors
     * @return JsonResponse
     */
    public static function validation(array $errors)
    {
        $response['message'] = ValidationMessage::getValidationErrorOccurred();
        $response['errors'] = Helper::resolveValidationErrors($errors);
        return self::failure($response, 422);
    }

    /**
     * @param null $message
     * @param null $errors
     * @param int $code
     * @return JsonResponse
     */
    public static function errorResponse($message = null, $errors = null, $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    /**
     * @param null $message
     * @param null $data
     * @return JsonResponse
     */
    public static function successResponse($message = null, $data = null)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'result' => $data,
        ], 200);
    }
}


