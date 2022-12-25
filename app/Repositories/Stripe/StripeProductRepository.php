<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use App\Stripe\StripeProduct;
  use App\Utils\Traits\ThrowTrait;
  use Stripe\Exception\ApiErrorException;

  class StripeProductRepository extends StripeBase
  {
    use ThrowTrait;
    /**
     * StripeProductRepository constructor.
     */
    public function __construct()
    {
      parent::__construct();
    }
  
    /**
     * @param string $productName
     * @return StripeProduct|null
     * @throws ErrorResponseException
     */
    public function createProduct(string $productName)
    {
      if ($this->checkIfProductAlreadyExists($productName)) {
        return null;
      }
      $response = null;
      try {
        $response = $this->stripe->products->create([
          'name' => $productName
        ]);
      } catch (ApiErrorException $e) {
        $this->throw($e->getMessage());
      }
  
      $product = new StripeProduct;
      $product->stripe_id = $response->id;
      $product->name = $response->name;
      $product->object = $response->object;
      $product->active = $response->active;
      $product->attributes = serialize($response->attributes);
      $product->description = $response->description;
      $product->images = serialize($response->images);
      $product->livemode = $response->livemode;
      $product->statement_descriptor = $response->statement_descriptor;
      $product->type = $response->type;
      $product->unit_label = $response->unit_label;
      $product->save();
      
      return $product;
    }
  
    /**
     * @param string $productName
     * @return bool
     */
    private function checkIfProductAlreadyExists(string $productName)
    {
      return StripeProduct::whereName($productName)->exists();
    }
  }
