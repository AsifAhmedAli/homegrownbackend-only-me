<?php

namespace App\Http\Controllers\Voyager;

use App\Gx\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoyagerTicketController extends VoyagerController
{
    public function reply($ticketID)
    {
      $ticket = Ticket::myCustomerData()->findOrFail($ticketID);

      return redirect()->to('admin/ticket-messages/create?ticket=' . $ticket->id);
    }
}
