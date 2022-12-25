<?php


  namespace App\Repositories\Hydro;


  use App\Cart;
  use App\Order;
  use App\Utils\Helpers\Helper;
  use Exception;

  class HydroOrderRepository extends HydroBaseRepository
  {
    private const API_URL = '/salesorders/submitorder';
    private $order;

    /**
     * HydroOrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
      $this->order = $order;
      parent::__construct(self::API_URL, 'post', 'write hydrofarmApi');
    }

    /**
     * @throws Exception
     */
    private function submit()
    {
        if (env('HYDROFARM_ENV') == "sandbox") {
            $fields = $this->testDetail();
        } else {
            $fields = [
                'poNumber' => $this->order->id,
                'comments' => 'this is test order',
                'shippingOptions' => [
                    'shippingMode' => 'dropShipment',
                    'shipToName' => Helper::concatenate('ucwords', Helper::getValue($this->order->shipping_first_name, $this->order->billing_first_name), Helper::getValue($this->order->shipping_last_name, $this->order->billing_last_name)),
                    'address' => Helper::getValue($this->order->shipping_address_1, $this->order->billing_address_1),
                    'city' => Helper::getValue($this->order->shipping_city, $this->order->billing_city),
                    'state' => Helper::getValue($this->order->shipping_state, $this->order->billing_state),
                    'zip' => Helper::getValue($this->order->shipping_zip, $this->order->billing_zip),
                    'phone' => Helper::getValue($this->order->shipping_address_phone, $this->order->billing_address_phone),
                    'country' => 'USA',
                ]
            ];

        }

      foreach ($this->order->products as $orderProduct) {
        if($orderProduct->hydro_product_id) {
          $fields['salesLines'][] = [
            'sku' => $orderProduct->product->sku,
            'qty' => $orderProduct->qty,
            'uom' => $orderProduct->product->defaultuom
          ];
        }
      }
      $this->setFields($fields);
      $response = $this->process();
      if($response && isset($response->docRef)) {
        $this->order->hydro_doc_ref = $response->docRef;
        $this->order->save();
      }

      return $this->order;
    }

    private function testDetail() {
        $fields = [
            'poNumber' => $this->order->id,
            'comments' => 'this is test order',
            'shippingOptions' => [
                'shippingMode' => 'dropShipment',
                'shipToName' => "Test",
                'address' => "Test",
                'city' => Helper::getValue($this->order->shipping_city, $this->order->billing_city),
                'state' => Helper::getValue($this->order->shipping_state, $this->order->billing_state),
                'zip' => Helper::getValue($this->order->shipping_zip, $this->order->billing_zip),
                'phone' => Helper::getValue($this->order->shipping_address_phone, $this->order->billing_address_phone),
                'country' => 'USA',
            ]
        ];
        return $fields;
    }

    /**
     * @return Order
     */
    public function send()
    {
      if(!Helper::empty($this->order->hydro_doc_ref)) {
        return $this->order;
      }
      try {
        $tries = 0;
        do{
          $this->order = $this->submit();
          $tryAgain = Helper::empty($this->order->hydro_doc_ref) && $tries++ <= 3;
        } while($tryAgain);
        return $this->order;
      } catch (Exception $exception) {
        return $this->order;
      }
    }


  }
