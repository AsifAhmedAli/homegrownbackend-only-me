<?php

namespace App\Jobs;

use App\Hydro\HydroCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Artisan;

class SyncHydroProducts implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  public $tries = 10;
  public $retryAfter = 20;
  private $hydroCategory;
  private $sync;
  
  /**
   * Create a new job instance.
   *
   * @param HydroCategory $hydroCategory
   * @param bool $sync
   */
  public function __construct(HydroCategory $hydroCategory, bool $sync = false)
  {
    $this->hydroCategory = $hydroCategory;
    $this->sync = $sync;
  }
  
  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Artisan::call('import:products', [
      'category' => $this->hydroCategory->hydro_id,
      '--sync' => $this->sync
    ]);
  }
}
