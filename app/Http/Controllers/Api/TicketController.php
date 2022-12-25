<?php

namespace App\Http\Controllers\Api;

use App\Gx\Ticket;
use App\Gx\TicketMessage;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use App\Utils\Helpers\Helper;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TicketController extends ApiBaseController
{
  private $ticket;
  public function __construct(Ticket $ticket) {
    parent::__construct();
    $this->ticket = $ticket;
  }
  
  /**
   * @return Ticket|Model|Eloquent
   */
  private function baseQuery()
  {
    return $this->ticket->ofUser($this->getUserID());
  }
  
  public function create(Request $request)
  {
    $rules = ValidationRule::ticket();
  
    $messages = ValidationMessage::ticket();
  
    try {
      $this->validate($request, $rules, $messages);
    } catch (ValidationException $e) {
      return ApiResponse::validation($e->errors());
    }
    
    $ticket = new Ticket();
    $ticket->user_id = $this->getUserID();
    $ticket->title = $request->title;
    $ticket->priority = ucwords($request->priority);
    $ticket->save();
    
    $ticketMessage = new TicketMessage();
    $ticketMessage->ticket_id = $ticket->id;
    $ticketMessage->user_id = $ticket->user_id;
    $ticketMessage->message = $request->description;
    $ticketMessage->save();
    $this->saveMedia($ticketMessage);
    
    Helper::sendNewTicketEmail($ticket, $ticketMessage);
  
    $response['tickets'] = $this->baseQuery()->with('messages', 'messages.user')->latest('id')->get();
    $response['message'] = 'Ticket submitted successfully.';
    
    return ApiResponse::success($response);
  }
  
  public function get()
  {
    $response['tickets'] = $this->baseQuery()->with('messages', 'messages.user')->latest('id')->get();
    
    return ApiResponse::success($response);
  }
  
  private function findTicket($ticketID)
  {
    return $this->ticket->with('messages', 'messages.user')->findOrFail($ticketID);
  }
  
  public function find($ticketID)
  {
    $response['ticket'] = $this->findTicket($ticketID);
    
    return ApiResponse::success($response);
  }
  
  public function send(Request $request, $ticketID)
  {
    $ticket = $this->ticket->findOrFail($ticketID);
    
    $rules = [
      'message' => 'required'
    ];
  
    $messages = ValidationMessage::ticket();
  
    try {
      $this->validate($request, $rules, $messages);
    } catch (ValidationException $e) {
      return ApiResponse::validation($e->errors());
    }
  
    $ticketMessage = new TicketMessage();
    $ticketMessage->ticket_id = $ticket->id;
    $ticketMessage->user_id = $this->getUserID();
    $ticketMessage->message = $request->message;
    $ticketMessage->save();
    $this->saveMedia($ticketMessage);
    
//    if (strtolower($ticket->status) === 'closed') {
      $ticket->status = 'open';
      $ticket->save();
//    }
  
    Helper::sendNewTicketMessageEmail($ticket, $ticketMessage);
    
    $response['message'] = 'Message posted successfully';
    $response['ticket'] = $this->findTicket($ticketID);
    
    return ApiResponse::success($response);
  }
  
  private function saveMedia(TicketMessage $ticketMessage)
  {
    if (request()->has('media')) {
      try {
        $images = [];
        foreach (request('media') as $media) {
          $base64_image = Helper::arrayIndex($media, 'base64', null);
          if (!Helper::empty($base64_image)) {
            $imageName = Helper::createImageFromBase64($base64_image, 'ticket-messages');
            $images[] = (object)[
              'download_link' => $imageName,
              'original_name' => $imageName,
              'extension' => Helper::resolveExtension(Helper::getTypeFromBase64($base64_image)),
              'unique_id' => uniqid()
            ];
          }
        }
        
        $ticketMessage->attachments = json_encode($images);
        $ticketMessage->save();
      } catch (Exception $exception) {}
    }
  }
}
