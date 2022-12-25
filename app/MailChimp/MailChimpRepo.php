<?php


  namespace App\MailChimp;


  use App\Exceptions\Response\ErrorResponseException;
  use App\Utils\Helpers\Helper;
  use Exception;
  use App\Cart;
  use App\User;
  use Illuminate\Database\Eloquent\Collection;
  use Illuminate\Database\Eloquent\Model;
  use MailChimp\MailChimp;
  use App\Hydro\HydroProduct;

  class MailChimpRepo
  {
    private const STORE_ID = 'HGP-ABANDONED'; // Just for creating store for first time
    private const STORE_NAME = 'HGP Abandoned Cart'; // Just for creating store for first time

    protected $store_id;

    protected $abandoned_cart_id;

    protected $list_id;

    protected $mc;

    protected $user_id;

    protected $is_guest;

    private $cart;

    /**
     * MailChimpRepo constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
      $this->mc = new MailChimp;
      $this->cart = $cart;
      $this->list_id = config('services.mailchimp.list_id');
      $this->store_id = config('services.mailchimp.store_id');
      $this->abandoned_cart_id = config('services.mailchimp.abandoned_id');
      $this->user_id = $this->cart->user_id? $this->cart->user_id : $this->cart->billing_address_email;
      $this->is_guest = Helper::empty($this->cart->user_id) && !Helper::empty($this->cart->billing_address_email);
    }

    public function init()
    {
      /*
       * Steps to Start Abandoned Cart (for first time only)
       * Check for available list id using ($this->getLists())
       * Create Store ($this->createStore())
       * Update Store ($this->updateStore())
       * Go to MailChimp and create Abandoned Cart Email/Series and select store name just created above
       * Get Automations list from MailChimp using ($this->getAutomations()) and take that abandoned cart email series id and save to env
       * You are good to go with implemented functionality now
       */
    }

    /**
     * @return object
     */
    private function getAutomations()
    {
      return $this->mc->automations()->getAutomations();
    }

    /**
     * @return object
     */
    private function getLists()
    {
      return $this->mc->lists()->getLists();
    }

    /**
     * @return object
     */
    private function createStore()
    {
      return $this->mc->ecommerce()->addStore(self::STORE_ID , $this->list_id , self::STORE_NAME, 'USD');
    }

    /**
     * @return mixed
     */
    private function updateStore()
    {
      return $this->mc->ecommerce()->updateStore(self::STORE_ID , [
       	'platform' => 'laravel',
       	'domain' => 'https://hgp.dotlogicstest.com/',
       	'email_address' => 'info@homegrown-pros.com',
       	'timezone' => 'America/New_York',
       	'phone' => '+1 123-456-7890',
       	'address' => [
       		'address1' => '46 Cain Dr',
       		'city' => 'Plainview',
       		'province' => 'N',
       		'state' => 'NY',
       		'zip' => '07623-3166',
       		'postal_code' => '11803-4429',
       		'country' => 'US',
       		'country_code' => 'USD',
       		'phone' => '11803-4429',
       	],
       ]);
    }

    /**
     * @param $customer_id
     * @return User|User[]|Collection|Model|null
     */
    private function getCustomer($customer_id)
    {
      return User::find($customer_id);
    }

    /**
     * @param $customer_id
     * @param bool $remove
     */
    private function saveOrRemoveCustomerToMailchimp($customer_id , bool $remove = false)
    {
      $user = $this->getCustomer($customer_id);

      if($user){
        if($remove){
          $user->added_to_mailchimp_at = null;
        }else{
          $user->added_to_mailchimp_at = now();
        }
        $user->save();
      }
    }

    /**
     * @param $customer_id
     * @return bool|User|User[]|Collection|Model|null
     */
    public function addCustomer($customer_id)
    {
      $customer = null;
      try{
        $customer = $this->getCustomer($customer_id);
        if(!Helper::empty($customer) && Helper::empty($customer->added_to_mailchimp_at)){
          $response = $this->mc->ecommerce()->customers()->addCustomer($this->store_id , (string)$customer->id , (string)$customer->email , true , [
            'first_name' => (string)$customer->first_name,
            'last_name' => (string)$customer->last_name,
            'address' => [
              'address1' => (string)$customer->street_address_1,
              'city' => (string)$customer->city,
              'state' => (string)$customer->state,
              'zip' => (string)$customer->zip_code,
              'country' => 'USA',
              'phone' => (string)$customer->phone_no,
            ]
          ]);
//          dd($response, $this->store_id);
          if(isset($response->id)){
            $this->saveOrRemoveCustomerToMailchimp($response->id);
          }
        }
        return $customer;
      }catch (Exception $e){
        return $customer;
      }
    }

    /**
     * @param $customer_id
     * @return bool|User|User[]|Collection|Model|null
     */
    public function reAddCustomer($customer_id)
    {
      $customer = $this->getCustomer($customer_id);
      if(!Helper::empty($customer) && !Helper::empty($customer->added_to_mailchimp_at)){
        $this->deleteMailChimpCustomer($customer_id);
      }
      return $this->addCustomer($customer_id);
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public function deleteMailChimpCustomer($customer_id)
    {
      $response = $this->mc->ecommerce()->customers()->deleteCustomer($this->store_id , $customer_id);
      $this->saveOrRemoveCustomerToMailchimp($customer_id, true);

      return $response;
    }

    /**
     * @return bool
     */
    public function deleteAllMailChimpCustomers()
    {
      try{
        $allCustomers = $this->getMailChimpCustomers();

        if(isset($allCustomers->total_items) && $allCustomers->total_items && isset($allCustomers->customers)){
          foreach ($allCustomers->customers as $key => $customer) {
            if(isset($customer->id)){
              $this->deleteMailChimpCustomer($customer->id);
            }
          }
        }
      }catch (Exception $e){
        return true;
      }
      return true;
    }

    /**
     * @return object
     */
    public function getMailChimpCustomers()
    {
      return $this->mc->ecommerce()->customers()->getCustomers($this->store_id);
    }

    /**
     * @param $hydro_product_id
     * @return Collection|Model|HydroProduct|null
     */
    private function getProduct($hydro_product_id)
    {
      return HydroProduct::find($hydro_product_id);
    }

    /**
     * @param $hydro_product_id
     * @param bool $remove
     */
    private function saveOrRemoveProductToMailchimp($hydro_product_id , bool $remove = false)
    {
      $product = $this->getProduct($hydro_product_id);

      if($product){
        if($remove){
          $product->added_to_mailchimp_at = null;
        }else{
          $product->added_to_mailchimp_at = now();
        }
        $product->save();
      }
    }

    public function addProduct($product_id)
    {
      try{
        $product = $this->getProduct($product_id);

        if(!Helper::empty($product) && Helper::empty($product->added_to_mailchimp_at)){
          $variants = [];
          $variants[] = [
            'id' => (string)$product->id,
            'title' => (string)$product->name,
            'url' => (string)Helper::url("product/{$product->sku}"),
            'sku' => (string)$product->sku,
            'image_url' => (string)optional($product->image)->url,
            'price' => (string)optional($product->price)->retailPrice,
          ];
          $response = $this->mc->ecommerce()->products()->addProduct(
            $this->store_id,
            (string)$product->id,
            (string)$product->name,
            $variants,
            [
              'image_url' => (string)optional($product->image)->url,
              'url' => (string)Helper::url("product/{$product->slug}"),
              'sku' => (string)$product->sku,
              'price' => (string)optional($product->price)->retailPrice,
            ]
          );
          if(isset($response->id)){
            $this->saveOrRemoveProductToMailchimp($product_id);
          }
        }

        return $product;
      }catch (Exception $e){
        return true;
      }
    }

    /**
     * @param $product_id
     */
    public function reAddProduct($product_id)
    {
        $product = $this->getProduct($product_id);
        if(!Helper::empty($product) && !Helper::empty($product->added_to_mailchimp_at)){
          $this->deleteMailChimpProduct($product_id);
        }
        $this->addProduct($product_id);
    }

    /**
     * @param $product_id
     * @return mixed
     */
    public function deleteMailChimpProduct($product_id)
    {
      $response = $this->mc->ecommerce()->products()->deleteProduct($this->store_id , $product_id);
      $this->saveOrRemoveProductToMailchimp($product_id, true);

      return $response;
    }

    /**
     * @return bool
     */
    public function deleteAllMailChimpProducts()
    {
      try{
        $allProducts = $this->getMailChimpProducts();

        if(isset($allProducts->total_items) && $allProducts->total_items && isset($allProducts->products)){
          foreach ($allProducts->products as $key => $product) {
            if(isset($product->id)){
              $this->deleteMailChimpProduct($product->id);
            }
          }
        }
        return true;
      }catch (Exception $e){
        return true;
      }
    }

    /**
     * @return object
     */
    public function getMailChimpProducts()
    {
      return $this->mc->ecommerce()->products()->getProducts($this->store_id);
    }

    /**
     * @return bool
     */
    private function cartAlreadyExists()
    {
      $gma = $this->getMailChimpAutomation($this->user_id);

      if(!Helper::empty($gma)){
        $response = $this->mc->ecommerce()->carts()->getCart($this->store_id, $gma->cart_id);

        return !Helper::empty($response);
      }else{
        return false;
      }
    }

    /**
     * @return bool|mixed
     */
    public function deleteWholeCart()
    {
      try{
        $user_id = $this->user_id;
        $gma = $this->getMailChimpAutomation($user_id);
        if(!Helper::empty($gma)){
          return $this->deleteCart($gma->cart_id);
        }
      }catch(Exception $error){
        return true;
      }
      return true;
    }

    /**
     * @param $cart_id
     * @return mixed
     */
    public function deleteCart($cart_id)
    {
      return $this->mc->ecommerce()->carts()->deleteCart($this->store_id , $cart_id);
    }

    /**
     * @param $cart_id
     * @throws Exception
     */
    private function deleteCartFromDB($cart_id)
    {
      MailchimpAutomation::whereCartId($cart_id)->delete();
    }

    /**
     * @return bool|mixed
     */
    public function resetMailChimpCart()
    {
      if($this->cartAlreadyExists()){
        return $this->deleteWholeCart();
      }
      return false;
    }

    private function getCartItems()
    {
      try{
        $items = [];

        foreach ($this->cart->products as $cartProduct) {
            $this->addProduct($cartProduct->hydro_product_id);
            $id = (string)$cartProduct->id;
            $product_id = (string)$cartProduct->hydro_product_id;
            $product_variant_id = $product_id;
            $items[] = [
              'id' => $id,
              'product_id' => $product_id,
              'product_variant_id' => $product_variant_id,
              'quantity' => $cartProduct->quantity,
              'price' => $cartProduct->total_price,
            ];
        }
        return $items;
      }catch (Exception $e){
        return true;
      }
    }

    /**
     * @return bool
     */
    public function addToCart()
    {
      try{
        if($this->is_guest){
          return false;
//          return $this->addToCartForGuest();
        }elseif($this->user_id){
          return $this->addToCartForCustomer();
        }else{
          return false;
        }
      }catch (Exception $e){
        return false;
      }
    }

    /**
     * @return bool
     */
    private function addToCartForCustomer()
    {
      try{
        $this->resetMailChimpCart();
        $user_id = $this->user_id;
        $cart_id = uniqid("{$user_id}-");
//        $customer = $this->addCustomer($user_id);
        $customer = $this->getCustomer($user_id);
        $cartItems = $this->getCartItems();
        if(count($cartItems)){
          if(!Helper::empty($customer)){
            $response = $this->mc->ecommerce()->carts()->addCart($this->store_id , $cart_id , 'USD' , $this->cart->total_price ,
              [
                'id' => (string)$customer->email,
                'email_address' => (string)$customer->email,
                'opt_in_status' => true,
              ],
              $cartItems,
              [
                'campaign_id' => (string)$this->abandoned_cart_id,
                'checkout_url' => Helper::url('cart')
              ]
            );

            if(isset($response->id)){
              $this->generateMailChimpCartID($user_id , $cart_id);
              return true;
            }else{
              return false;
            }
          }else{
            return false;
          }
        }else{
          $this->deleteWholeCart();
        }

      }catch (Exception $e){
        return true;
      }
      return true;
    }

    /**
     * @return bool
     */
    public function addToCartForGuest()
    {
      try{
        $this->resetMailChimpCart();
        $user_id = $this->user_id;
        $cart_id = uniqid("{$user_id}-");
        $cartItems = $this->getCartItems();
        if(count($cartItems)){
          $response = $this->mc->ecommerce()->carts()->addCart($this->store_id , $cart_id , 'USD' , $this->cart->total_price ,
            [
              'id' => (string)$user_id,
              'email_address' => (string)$user_id,
              'opt_in_status' => true,
            ],
            $cartItems,
            [
              'campaign_id' => $this->abandoned_cart_id,
              'checkout_url' => Helper::url('cart')
            ]
          );
          if(isset($response->id)){
            $this->generateMailChimpCartID($user_id , $cart_id);
            return true;
          }else{
            return false;
          }
        }else{
          $this->deleteWholeCart();
        }

      }catch (Exception $e){
        return true;
      }
      return true;
    }

    /**
     * @param $line_id
     * @return bool
     */
    public function removeItemFromCart($line_id)
    {
      try{
        if(!Helper::empty($this->cart->user_id) || $this->is_guest){
          $gma = $this->getMailChimpAutomation($this->user_id);

          if(!Helper::empty($gma)){
            $this->mc->ecommerce()->carts()->deleteCartLine($this->store_id , $gma->cart_id , $line_id);
          }
        }else{
          return false;
        }
      }catch (Exception $e){
        return true;
      }
      return true;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    private function getMailChimpAutomation($user_id)
    {
      return MailchimpAutomation::ofUser($user_id)->first();
    }

    /**
     * @param $user_id
     * @param $cart_id
     * @return MailchimpAutomation|MailchimpAutomation[]|Collection|Model|null
     */
    private function generateMailChimpCartID($user_id , $cart_id)
    {
      $already = MailchimpAutomation::ofUser($user_id)->first();

      if($already){
        $ma = MailchimpAutomation::find($already->id);
      }else{
        $ma = new MailchimpAutomation;
      }
      $ma->user_id = $user_id;
      $ma->cart_id = $cart_id;
      $ma->save();

      return $ma;
    }

    /**
     * @return object
     */
    public function getCarts()
    {
      return $this->mc->ecommerce()->carts()->getCarts($this->store_id);
    }

    /**
     * @return bool
     */
    public function deleteAllMailChimpCarts()
    {
      try{
        $allCarts = $this->getCarts();

        if(isset($allCarts->total_items) && $allCarts->total_items && isset($allCarts->carts)){
          foreach ($allCarts->carts as $key => $cart) {
            if(isset($cart->id)){
              $this->deleteCart($cart->id);
              $this->deleteCartFromDB($cart->id);
            }
          }
        }
      }catch (Exception $e){
        return true;
      }
      return true;
    }

    /**
     * Reset Everything on MailChimp
     */
    public function resetAllMailChimpData()
    {
      $this->deleteAllMailChimpCarts();
      $this->deleteAllMailChimpProducts();
      $this->deleteAllMailChimpCustomers();
    }
  }
