<?php
  
  
  namespace App\Repositories\Paypal;
  
  use App\PaypalToken;
  use App\Utils\Constants\Paypal;
  use http\Exception;
  use Illuminate\Http\Client\RequestException;
  use Illuminate\Support\Facades\Http;
  use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

  class PaypalBaseService
  {
    
    private $completeAPIURL;
    private $curl;
    public  $accessToken;
    private $method = 'post';
    private $env;
    private $grantType;
    private $apiURL;
    private $clientID;
    private $clientSecret;
    private $planType;
    public  $paymentDefinitionType;
    public  $defaultFrequency;
    public  $defaultFrequencyInterval;
    private $currency;
    private $createdPlan;
    private $httpReqType;
    private $product;
    public  $autoBilling;
    public  $postFields;
    public  $access_token;
    public  $setup_fee;
  
    public function __construct($endpoint = 'oauth2/token')
    {

      $this->setHttpReqToType(Paypal::PLAN_REQUEST);
      $this->resolveCredentials();
      $this->setAPIURL($endpoint);
      $this->resolveAccessToken();
    }
  
    public function setMethod($method)
    {
      return $this->method = $method;
    }
  
    public function getMethod()
    {
      return $this->method;
    }
    
    public function setCurrency($currency)
    {
      return $this->currency = $currency;
    }
  
    public function getCurrency()
    {
      return $this->currency;
    }
  
    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
      $this->postFields = $fields;
    }
  
    /**
     * @return array|mixed
     */
    public function getFields()
    {
      return $this->postFields;
    }
  
    /**
     * set Keys
     */
    private function resolveCredentials()
    {
      $this->env                      = config('paypal.env');
      $this->grantType                = config('paypal.grant_type');
      $this->apiURL                   = config("paypal.{$this->env}_api_baseURL");
      $this->clientID                 = config("paypal.{$this->env}_client_id");
      $this->clientSecret             = config("paypal.{$this->env}_secret_id");
      $this->planType                 = config('paypal.plan.type');
      $this->paymentDefinitionType    = config('paypal.paymentDefinition.type');
      $this->autoBilling    = config('paypal.paymentDefinition.autoBillOutstanding');
      $this->defaultFrequency         = config('paypal.paymentDefinition.defaultFrequency');
      $this->defaultFrequencyInterval = config('paypal.paymentDefinition.defaultFrequencyInterval');
      $this->currency                 = config('paypal.amount.currency');
      $this->setup_fee                 = config('paypal.setup_fee.value');
//            dd($this->env, $this->grantType, $this->apiURL, $this->clientID, $this->clientSecret);
    }
    
    public function getSetupFee(){
      return $this->setup_fee;
    }
    public function getPlanType()
    {
      return $this->planType;
    }
  
    public function setAPIURL($endpoint, bool $replace = false)
    {
      if($replace) {
        $this->completeAPIURL = $endpoint;
      } else {
        $this->completeAPIURL = $this->apiURL . $endpoint;
      }
    }
    
    public function getAPIURL()
    {
      return $this->completeAPIURL;
    }
  
    protected function getAccessTokenObject()
    {
      try {
        $url = $this->apiURL.'oauth2/token';
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, "grant_type=" . $this->grantType);
        curl_setopt($this->curl, CURLOPT_USERPWD, $this->clientID . ':' . $this->clientSecret);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        $result = curl_exec($this->curl);
        if (curl_errno($this->curl)) {
          dd(curl_error($this->curl));
        }
        curl_close($this->curl);
        return json_decode($result);
      }catch (\Exception $e){
      }
      
    }
  
    private function getToken()
    {
      return PaypalToken::current($this->env);
    }
  
    /**
     * Get Access Token
     */
    private function resolveAccessToken()
    {
      $this->generateNewAccessToken();
//      $token = $this->getToken();
//      if ($token) {
//        $this->access_token = $token->access_token;
//      } else {
//        $this->generateNewAccessToken();
//      }
    }
  
    public function getAccessToken()
    {
      return $this->access_token;
    }
  
    protected function setAccessToken($token)
    {
      $this->access_token = $token;
    }
  
    private function getHeaders()
    {
      $headers   = array();
      $headers[] = 'Accept: application/json';
      $headers[] = 'Accept-Language: en_US';
      $headers[] = 'Content-Type: application/x-www-form-urlencoded';
      return $headers;
    }
  
    public function setHttpReqToType(string $type)
    {
      $this->httpReqType = $type;
    }
  
    public function getHttpReqType()
    {
      $this->httpReqType;
    }
  
    /**
     * @return array|object
     * @throws Exception
     */
    public function process()
    {
      try {
        $response = Http::withToken($this->getAccessToken())->retry(5, 100);
        if ($this->method === 'get') {
          $response = $response->get($this->completeAPIURL, $this->postFields ?? []);
        } elseif ($this->method === 'post') {
          $response = $response->post($this->completeAPIURL, $this->postFields ?? []);
        } else {
          $method   = $this->method;
          $response = $response->$method($this->completeAPIURL, $this->postFields ?? []);
        }
        if ($response->successful()) {
          if ($this->httpReqType == Paypal::PLAN_REQUEST) {
            $this->setCreatedPlan($response->object());
            $response = $this->getCreatedPlan();
          } else {
            $this->setProduct($response->object());
            $response = $this->getProduct();
          }
          return $response;
        } else {
          if ($response->status() === 401 || $response->status() === 403) {
            $this->reProcess();
          }
        }
      } catch (RequestException $exception) {
        if ($exception->getCode() === 401 || $exception->getCode() === 403) {
          $this->reProcess();
        }
      }
      return null;
    }
  
    /**
     * Re Generate Access Token if old is expired
     * @throws Exception
     */
    private function reProcess()
    {
      $this->generateNewAccessToken();
      $this->process();
    }
  
    private function generateNewAccessToken()
    {
      try {
        $accessTokenObject   = $this->getAccessTokenObject();
        if (isset($accessTokenObject) && !empty($accessTokenObject)) {
          PaypalToken::truncate();
          $token               = new PaypalToken();
          $token->env          = $this->env;
          $token->access_token = $accessTokenObject->access_token;
          $token->expires_in   = $accessTokenObject->expires_in;
          $token->save();
          $this->access_token = $accessTokenObject->access_token;
        }
      } catch (\Exception $exception) {
        exit($exception->getMessage());
      }
    }
  
    public function setCreatedPlan($plan)
    {
      $this->createdPlan = $plan;
    }
  
    public function getCreatedPlan()
    {
      return $this->createdPlan;
    }
  
    public function setProduct($product)
    {
      $this->product = $product;
    }
  
    public function getProduct()
    {
      return $this->product;
    }
    public function getProductId(){
      return $this->product->id;
    }
  }
