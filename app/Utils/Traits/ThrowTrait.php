<?php
  
  
  namespace App\Utils\Traits;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use Exception;

  trait ThrowTrait
  {
    /**
     * @param $message
     * @throws ErrorResponseException
     * @throws Exception
     */
    public function throw($message)
    {
//      if (request()->ajax()) {
        throw new ErrorResponseException($message);
//      } else {
//        throw new Exception($message);
//      }
    }
  }
