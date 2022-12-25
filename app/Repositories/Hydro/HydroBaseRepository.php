<?php


  namespace App\Repositories\Hydro;


  use App\Utils\Helpers\Helper;
  use Exception;
  use App\Hydro\HydroProduct;
  use App\Hydro\HydroProductAttribute;
  use App\Hydro\HydroProductBarCode;
  use App\Hydro\HydroProductDimension;
  use App\Hydro\HydroProductDocument;
  use App\Hydro\HydroProductFamilyItem;
  use App\Hydro\HydroProductImage;
  use App\Hydro\HydroProductInventory;
  use App\Hydro\HydroProductPriceWholeSalePrice;
  use App\Hydro\HydroProductRelated;
  use App\Hydro\HydroProductRestriction;
  use App\Hydro\HydroProductUomConversion;
  use App\Hydro\HydroToken;
  use Illuminate\Http\Client\RequestException;
  use Http;
  use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
  use League\OAuth2\Client\Provider\GenericProvider;

  class HydroBaseRepository
  {
    private $env;
    private $grantType;
    private $accessTokenURL;
    private $clientID;
    private $clientSecret;
    private $scope;
    private $access_token;
    private $apiUrl;
    private $postFields;
    private $method;

    /**
     * HydroBase constructor.
     * @param string $apiUrl
     * @param string $method
     * @param string $scope
     */
    public function __construct(string $apiUrl, string $method = 'get', string $scope = 'read hydrofarmApi')
    {
      $this->setScope($scope);
      $this->resolveCredentials();
      $this->resolveAccessToken();
      $this->setApiUrl($apiUrl);
      $this->setMethod($method);
    }

    /**
     * set Keys
     */
    private function resolveCredentials()
    {
      $this->env = config('services.hydrofarm.env');
      $this->grantType = config('services.hydrofarm.grant_type');
      $this->accessTokenURL = config("services.hydrofarm.{$this->env}_access_token_url");
      $this->clientID = config("services.hydrofarm.{$this->env}_client_id");
      $this->clientSecret = config("services.hydrofarm.{$this->env}_client_secret");
    }

    /**
     * Get Access Token
     */
    private function resolveAccessToken()
    {
      $hydroToken = $this->getToken();
      if($hydroToken) {
        $this->access_token = $hydroToken->access_token;
      } else {
        $this->generateNewAccessToken();
      }
    }

    protected function setScope(string $scope)
    {
      $this->scope = $scope;
    }

    protected function setMethod(string $method)
    {
      $this->method = $method;
    }

    private function generateNewAccessToken()
    {
      $provider = new GenericProvider([
        'clientId' => $this->clientID,
        'clientSecret' => $this->clientSecret,
        'urlAuthorize' => null,
        'urlAccessToken' => $this->accessTokenURL,
        'urlResourceOwnerDetails' => 'https://oauth.hydrofarm.com/resources ',
        'scope' => $this->scope
      ]);

      try {
        $accessToken = $provider->getAccessToken($this->grantType, [
          'scope' => $this->scope
        ]);
        $token = new HydroToken;
        $token->env = $this->env;
        $token->access_token = $accessToken->getToken();
        $token->expires_in = $accessToken->getExpires();
        $token->save();

        $this->access_token = $token->access_token;

      }
      catch (IdentityProviderException $exception) {
        exit($exception->getMessage());
      }
    }

    /**
     * @return HydroToken|null
     */
    private function getToken()
    {
      return HydroToken::current($this->env);
    }

    /**
     * @param string $apiUrl
     * @return string
     */
    protected function resolveApiUrl(string $apiUrl)
    {
      return config("services.hydrofarm.{$this->env}_url") . $apiUrl;
    }

    /**
     * @param string $apiUrl
     * @param bool $contactBaseUrl
     */
    protected function setApiUrl(string $apiUrl, bool $contactBaseUrl = true)
    {
      if($contactBaseUrl) {
        $this->apiUrl = $this->resolveApiUrl($apiUrl);
      } else {
        $this->apiUrl = $apiUrl;
      }
    }

    /**
     * @param string $apiUrl
     * @param array $queryParams
     */
    protected function renewApiUrl(string $apiUrl, array $queryParams = [])
    {
      $this->apiUrl = $this->resolveApiUrl($apiUrl) . (Helper::empty(http_build_query($queryParams)) ? '' : '?' . http_build_query($queryParams));
    }

    /**
     * @return string|mixed
     */
    protected function getApiUrl()
    {
      return $this->apiUrl;
    }

    /**
     * @param array $fields
     */
    protected function setFields(array $fields)
    {
      $this->postFields = $fields;
    }

    /**
     * @return array|mixed
     */
    protected function getFields()
    {
      return $this->postFields;
    }

    /**
     * @return array|object
     * @throws Exception
     */
    protected function process()
    {
      try {
        $response = Http::withToken($this->access_token)->retry(5, 100);
        if($this->method === 'get') {
          $response = $response->get($this->apiUrl, $this->postFields ?? []);
        } elseif($this->method === 'post') {
          $response = $response->post($this->apiUrl, $this->postFields ?? []);
        } else {
          $method = $this->method;
          $response = $response->$method($this->apiUrl, $this->postFields ?? []);
        }
        if($response->successful()) {
          return $response->object();
        } else {
          if($response->status() === 401 || $response->status() === 403) {
            $this->reProcess();
          }
        }
      } catch (RequestException $exception) {
        if($exception->getCode() === 401 || $exception->getCode() === 403) {
          $this->reProcess();
        }
      }

      return null;
    }

    /**
     * @throws Exception
     */
    protected function post()
    {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $this->apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($this->postFields),
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer {$this->access_token}",
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);
      if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
        dd($response);
      }else if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == 401 || curl_getinfo($curl, CURLINFO_HTTP_CODE) == 403) {
        $this->rePost();
      }
      curl_close($curl);

      return $response;
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

    /**
     * Re Generate Access Token if old is expired
     * @throws Exception
     */
    private function rePost()
    {
      $this->generateNewAccessToken();
      $this->post();
    }

    /**
     * @param HydroProduct|HydroProductAttribute|HydroProductRestriction|HydroProductRelated|HydroProductImage|HydroProductDocument|HydroProductPriceWholeSalePrice|HydroProductBarCode|HydroProductDimension|HydroProductUomConversion|HydroProductInventory|HydroProductFamilyItem $model
     * @param $data
     * @return HydroProduct|HydroProductAttribute|HydroProductRestriction|HydroProductRelated|HydroProductImage|HydroProductDocument|HydroProductPriceWholeSalePrice|HydroProductBarCode|HydroProductDimension|HydroProductUomConversion|HydroProductInventory|HydroProductFamilyItem
     */
    protected function saveDynamic($model, $data)
    {
      $columns = \Schema::getColumnListing($model->getTable());
      foreach ($columns as $column) {
        if(property_exists($data, $column)) {
          $model->{$column} = $this->resolveColumn($data->{$column});
        }
      }

      if(Helper::unique($model)) {
        $model->save();
      }

      return $model;
    }

    /**
     * @param $data
     * @return string|int|float|boolean|null
     */
    private function resolveColumn($data)
    {
      if($data == '1900-01-01T00:00:00') {
        return null;
      }

      return $data;
    }
  }
