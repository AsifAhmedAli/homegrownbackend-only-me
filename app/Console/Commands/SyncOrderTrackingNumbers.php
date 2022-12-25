<?php

namespace App\Console\Commands;

use App\Repositories\Hydro\HydroOrdersRepository;
use Exception;
use Illuminate\Console\Command;

class SyncOrderTrackingNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Hydro Order Tracking Numbers';

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
     * @param HydroOrdersRepository $hydroOrdersRepository
     * @return mixed
     * @throws Exception
     */
    public function handle(HydroOrdersRepository $hydroOrdersRepository)
    {
        $hydroOrdersRepository->syncTrackingNumbers();
        $this->info('Order Tracking Information Synced.');
    }
}
