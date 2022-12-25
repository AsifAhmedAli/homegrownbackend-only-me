<?php

namespace App\Console;

use App\Console\Commands\CloseUnAnsweredTickets;
use App\Console\Commands\ImportHydroCategories;
use App\Console\Commands\ImportHydroProducts;
use App\Console\Commands\QueueProducts;
use App\Console\Commands\SendRemainingOrdersToHydroFarm;
use App\Console\Commands\SyncHydroProductFamily;
use App\Console\Commands\SyncOrderTrackingNumbers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
      ImportHydroCategories::class,
      ImportHydroProducts::class,
      QueueProducts::class,
      SyncHydroProductFamily::class,
      SendRemainingOrdersToHydroFarm::class,
      SyncOrderTrackingNumbers::class,
      CloseUnAnsweredTickets::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $schedule->command('queue:products')->weekly();
      $schedule->command('import:categories')->weekly();
      $schedule->command('orders:send')->everyTenMinutes();
      $schedule->command('tracking:sync')->hourly();
      $schedule->command('tickets:close')->daily();
  
      $schedule->command('scout:flush "App\Hydro\HydroProduct"')->daily();
      $schedule->command('scout:import "App\Hydro\HydroProduct"')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
