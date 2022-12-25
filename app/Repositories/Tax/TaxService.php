<?php
  
  
  namespace App\Repositories\Tax;
  use App\Cart;
  use App\Utils\Helpers\Helper;
  use Avalara\AvaTaxClient;
  use Avalara\DocumentType;
  use Avalara\TransactionBuilder;
  use Exception;

  class TaxService
  {
    public const DEFAULT_TAX_CODE = "P0000000";
    
    private $appName;
    private $appVersion;
    private $server;
    private $env;
    private $email;
    private $password;
    private $company_code;
    private $mode;
    private $cart;
    private $tax;
    private $fromAddress1;
    private $fromAddress2;
    private $fromCity;
    private $fromState;
    private $fromZip;
    private $fromCountry;
    
    public function __construct(Cart $cart)
    {
      $this->setKeys();
      $this->setFromAddress();
      $this->mode = config('services.avalara.mode');
      $this->tax = 0;
      $this->cart = $cart;
    }
    
    private function setKeys()
    {
      $this->appName = 'phpTestApp';
      $this->appVersion = '1.0';
      $this->server = 'localhost';
      $this->env = config('services.avalara.env');
      $this->email = config('services.avalara.email');
      $this->password = config('services.avalara.password');
      $this->company_code = 'DEFAULT';
    }
    
    private function setFromAddress()
    {
      $this->fromAddress1 = setting('site.address');
      $this->fromAddress2 = null;
      $this->fromCity = setting('site.city');
      $this->fromState = setting('site.state');
      $this->fromZip = setting('site.zip');
      $this->fromCountry = setting('site.country');
    }
  
    /**
     * @return bool
     */
    private function isActiveMode()
    {
      return $this->mode == 'active';
    }
  
    /**
     * @param bool $committed
     * @param null $amount
     * @throws Exception
     */
    public function calculate($committed = false, $amount = null)
    {
      $is_shipping_tax = !is_null($amount);
      if(is_null($amount)){
        $amount = (float)$this->cart->sub_total + (float)$this->cart->shipping_charges;
      }
      
      $tax = 0;
      if($this->isActiveMode() && $this->cart->hasBillingOrShipping())
      {
        $client = new AvaTaxClient($this->appName, $this->appVersion, $this->server, $this->env);
        $client->withSecurity($this->email, $this->password);
        $p = $client->ping();
        try {
          if ($p->authenticated) {
            $documentType = $committed ? DocumentType::C_SALESINVOICE : DocumentType::C_SALESORDER;
            $tb = new TransactionBuilder($client, $this->company_code, $documentType, $this->cart->customer_name);
            $tb->withAddress(
              'ShipFrom',
              $this->fromAddress1,
              $this->fromAddress2,
              null,
              $this->fromCity,
              $this->fromState,
              $this->fromZip,
              $this->fromCountry
            );
            $tb->withAddress(
              'ShipTo',
              Helper::getValue($this->cart->shipping_address_address1, $this->cart->billing_address_address1),
              Helper::getValue($this->cart->shipping_address_address2, $this->cart->billing_address_address2),
              null,
              Helper::getValue($this->cart->shipping_address_city, $this->cart->billing_address_city),
              Helper::getValue($this->cart->shipping_address_state, $this->cart->billing_address_state),
              Helper::getValue($this->cart->shipping_address_zip, $this->cart->billing_address_zip),
              'US'
            );
            if($committed) {
              $tb->withCommit();
            }
            if($is_shipping_tax) {
              $tb->withLine($amount, 1, null, self::DEFAULT_TAX_CODE);
            } else {
              $counter = 1;
              foreach ($this->cart->products as $cartProduct) {
                $tb->withLine($cartProduct->total_price, $cartProduct->quantity, null, $this->getTaxCode($cartProduct->hydro_product_id));
                $tb->withLineDescription(strip_tags($cartProduct->product->description));
                //              $tb->withLineDescription('Test Product');
                if($counter == 1) {
                  $tb->withItemDiscount(true);
                }
                ++$counter;
              }
              if((float)$this->cart->discount > 0){
                $tb->withDiscountAmount((float)$this->cart->discount);
              }
              try {
                $response = $tb->create();
                if(property_exists($response, 'summary')){
                  foreach ($response->summary as $key => $row) {
                    $tax += $row->tax;
                  }
                }
              } catch (\Exception $exception) {
        
              }
            }
          }
        } catch (Exception $exception) {
        
        }
      }
      
      $this->tax = $tax;
    }
  
    /**
     * @param $productID
     * this productID will be used if tax code is saved in DB against product
     * @return string
     */
    private function getTaxCode($productID)
    {
      return self::DEFAULT_TAX_CODE;
    }
    
    public function getTax()
    {
      return $this->tax;
    }
  }
