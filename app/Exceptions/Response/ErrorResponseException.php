<?php

namespace App\Exceptions\Response;

use App\Utils\Api\ApiResponse;
use Exception;
use Throwable;

class ErrorResponseException extends Exception
{
  protected $message;
  
  public function __construct($message = "", $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
    $this->message = $message;
  }
  
  public function render()
  {
    return ApiResponse::failure($this->message);
  }
}
