<?php

namespace App\Console\Commands;

use App\Order;
use App\Repositories\Hydro\HydroOrderRepository;
use Illuminate\Console\Command;

class SendRemainingOrdersToHydroFarm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Remaining Orders to HydroFarm';

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
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::hydro(false)->get();
        $bar = $this->output->createProgressBar(count($orders));
        $bar->start();
        foreach ($orders as $order) {
          $service = new HydroOrderRepository($order);
          $service->send();
          $bar->advance();
        }
        $bar->finish();
        $this->alert('All Orders sent to Hydro Farm');
    }
}
