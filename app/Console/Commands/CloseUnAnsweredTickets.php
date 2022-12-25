<?php

namespace App\Console\Commands;

use App\Gx\Ticket;
use App\Role;
use App\Utils\Constants\Constant;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CloseUnAnsweredTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $tickets = Ticket::with('last_message')->where('status', Constant::IN_PROGRESS)->get();
        
        foreach ($tickets as $ticket) {
          $lastMessage = optional($ticket->last_message);
          $user = optional($lastMessage)->user;
          if($lastMessage && $user && $user->role_id !== Role::NORMAL_USER_ROLE) {
            $ticketDate = Carbon::parse($lastMessage->created_at);
            $daysDiff = now()->diffInDays($ticketDate);
            if($daysDiff >= 7) {
              $ticket->status = Constant::CLOSED;
              $ticket->save();
            }
          }
        }
    }
}
