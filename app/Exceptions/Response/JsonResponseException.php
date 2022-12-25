<?php

namespace App\Exceptions\Response;

use App\Utils\Api\ApiResponse;
use Exception;
use Throwable;

class JsonResponseException extends Exception
{
  protected $response;
  
  public function __construct($response) {
    $this->response = $response;
  }
  
  public function render()
  {
    return ApiResponse::failure($this->response);
  }
}
