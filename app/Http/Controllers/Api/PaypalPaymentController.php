<?php
  
  namespace App\Http\Controllers\Api;
  
  use App\Http\Controllers\Controller;
  use App\Utils\Api\ApiResponse;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Support\Facades\Config;
  use PayPal\Api\Agreement;
  use PayPal\Api\Amount;
  use PayPal\Api\Payer;
  use PayPal\Api\Payment;
  use PayPal\Api\RedirectUrls;
  use PayPal\Api\Transaction;
  use Exception;
  use PayPal\Auth\OAuthTokenCredential;
  use PayPal\Rest\ApiContext;

  class PaypalPaymentController extends Controller
  {
    public $apiContext;
  
    public function __construct()
    {
      $this->apiContext = new ApiContext(
        new OAuthTokenCredential(Config::get('paypal.client_id'),
          Config::get('paypal.secret_id')
        )
      );
    }
    /**
     * Payment.
     *
     * @return JsonResponse
     */
    public function payment()
    {
      $payer = new Payer();
      $payer->setPaymentMethod('paypal');
      
      $amount = new Amount();
      $amount->setTotal('1.00');
      $amount->setCurrency('USD');
      
      $transaction = new Transaction();
      $transaction->setAmount($amount);
      
      $redirectUrls = new RedirectUrls();
      $redirectUrls->setReturnUrl("https://example.com/your_redirect_url.html")
        ->setCancelUrl("https://example.com/your_cancel_url.html");
      
      $payment = new Payment();
      $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);
      
      try {
        $payment->create($this->apiContext);
        $data['payment']                       = json_decode($payment);
        $data['redirect_user_to_approval_url'] = $payment->getApprovalLink();
        return ApiResponse::success($data);
      } catch (\PayPal\Exception\PayPalConnectionException $ex) {
        // This will print the detailed information on the exception.
        //REALLY HELPFUL FOR DEBUGGING
        return ApiResponse::failure($ex->getData());
      }
    }
    /**
     * This is the second part of CreateAgreement Sample.
     * Use this call to execute an agreement after the buyer approves it
     * @return JsonResponse
     */
  
    public function executeAgreement(){
      if (isset($_GET['success']) && $_GET['success'] == 'true') {
        $token     = $_GET['token'];
        $agreement = new Agreement();
        try {
          $agreement->execute($token, $this->apiContext);
        } catch (Exception $ex) {
          return ApiResponse::failure($ex->getMessage());
        }
      
        try {
          $agreement = Agreement::get($agreement->getId(), $this->apiContext);
          $data['agreement'] = json_decode($agreement);
          return ApiResponse::success($data);
        } catch (Exception $ex) {
          return ApiResponse::failure($ex->getMessage());
        }
      }else{
        return ApiResponse::failure('User Cancelled the Approval.');
      }
    
    }
    /**
     * PAYPAL
     * Get payment detail by id
     *
     * @param int $paymentId
     * @return JsonResponse
     */
    public function getPaymentdetail($paymentId)
    {
      try {
        $payment            = $this->getPaymentById($paymentId);
        $data['payment']    = json_decode($payment);
        $data['message'] = 'Payment Detail';
        return ApiResponse::success($data);
      } catch (Exception $ex) {
        return ApiResponse::failure($ex->getMessage());
      }
    }
  
    /**
     * PAYPAL
     * Get payment detail by id
     *
     * @param int $paymentId
     * @return Payment
     */
  
    public function getPaymentById($paymentId) {
      return Payment::get($paymentId, $this->apiContext);
    }
  }
