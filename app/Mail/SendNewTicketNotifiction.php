<?php

namespace App\Mail;

use App\Gx\Ticket;
use App\Gx\TicketMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewTicketNotifiction extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $ticketMessage;

    /**
     * Create a new message instance.
     *
     * @param Ticket $ticket
     * @param TicketMessage $ticketMessage
     */
    public function __construct(Ticket $ticket, TicketMessage $ticketMessage)
    {
      $this->ticket = $ticket;
      $this->ticketMessage = $ticketMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(__('generic.mail.gx.from'))
            ->subject('New Support Ticket')
            ->view('emails.gx.ticket.new');
    }
}
