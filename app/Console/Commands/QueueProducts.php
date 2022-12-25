<?php

namespace App\Console\Commands;

use App\Hydro\HydroCategory;
use App\Jobs\SyncHydroProducts;
use Illuminate\Console\Command;

class QueueProducts extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'queue:products';
  
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Queue Hydro Products for importing';
  
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
   * Execute the console command
   */
  public function handle()
  {
    $categories = HydroCategory::get();
    foreach ($categories as $key => $category) {
      SyncHydroProducts::dispatch($category, true);
    }
    $this->info('Jobs Queued!');
  }
}
