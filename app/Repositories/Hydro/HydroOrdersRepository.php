<?php
  
  
  namespace App\Repositories\Hydro;
  
  
  use App\Mail\SendTrackingNumberEmail;
  use App\Order;
  use App\OrderTrackingInformation;
  use App\Utils\Helpers\Helper;
  use Carbon\Carbon;
  use Exception;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Database\Eloquent\Collection;
  use Mail;

  class HydroOrdersRepository extends HydroBaseRepository
  {
    private const API_URL = '/salesorders/getorders';
    private $tries = 0;
    private $orders;
  
    /**
     * HydroOrdersRepository constructor.
     */
    public function __construct()
    {
      parent::__construct(self::API_URL, 'post');
      $this->orders = $this->getDisTrackedOrders();
    }
  
    /**
     * @return Order[]|Builder[]|Collection
     */
    private function getDisTrackedOrders()
    {
      return Order::distracked();
    }
  
    /**
     * @throws Exception
     */
    public function syncTrackingNumbers()
    {
      if($this->orders->count()) {
        $this->setFields([
          "dateRange" => [
            "start" => Carbon::parse($this->orders->min('created_at'))->subDay()->toISOString(),
            "include" => "true"
          ],
          "includeShipmentDetails" => "true",
          "orderStatus" => "invoiced"
        ]);
        $response = $this->process();
        
        if(Helper::empty($response) && $this->tries <= 2) {
          ++$this->tries;
          $this->syncTrackingNumbers();
        } else {
          if($response && is_array($response)) {
            foreach ($response as $hydroOrder) {
              try {
                $this->syncTrackingNumber($hydroOrder);
              } catch (Exception $exception) {}
            }
          }
        }
  
      }
    }
    
    private function syncTrackingNumber($hydroOrder)
    {
      if(is_array($hydroOrder->orderTracking) && count($hydroOrder->orderTracking)) {
        $order = $this->orders->where('hydro_doc_ref', $hydroOrder->refNumber)->first();
        if($order) {
          foreach ($hydroOrder->orderTracking as $trackingInfo) {
            $this->save($order, $trackingInfo);
          }
          Mail::to($order->billing_address_email)
            ->send(new SendTrackingNumberEmail($order));
        }
      }
    }
    
    private function save(Order $order, $trackingInfo)
    {
      if($order) {
        $tracking = OrderTrackingInformation::whereOrderId($order->id)->first();
        if(Helper::empty($tracking)) {
          $tracking = new OrderTrackingInformation;
          $tracking->order_id = $order->id;
        }
        $tracking->shipment_id = $trackingInfo->shipmentId;
        $tracking->so_number = $trackingInfo->soNumber;
        $tracking->invoice_id = $trackingInfo->invoiceId;
        $tracking->tracking = $trackingInfo->tracking;
        $tracking->carrier_code = $trackingInfo->carrierCode;
        $tracking->carrier_service_code = $trackingInfo->carrierServiceCode;
        $tracking->invent_site_id = $trackingInfo->inventSiteId;
        $tracking->tracking_link = $trackingInfo->trackingLink;
        $tracking->save();
      }
    }
  }
