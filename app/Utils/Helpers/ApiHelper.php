<?php
  if (!function_exists('successResponse')) {
    function    successResponse( $message = 'Successfully Done', $data = NULL)
    {
      return response()->json([
        'status'  => true,
        'message' => $message,
        'result'  => $data
      ], 200);
    }
  }
  if (!function_exists('errorResponse')) {
    function errorResponse($message = 'Something Wrong', $errors = NULL, $code = 400)
    {
      return response()->json([
        'status'  => false,
        'message' => $message,
        'errors'  => $errors
      ], $code);
    }
  }
