<?php

namespace App\Console\Commands;

use App\Hydro\HydroCategory;
use App\Repositories\Hydro\HydroCategoryRepository;
use Illuminate\Console\Command;
use Exception;

class ImportHydroCategories extends Command
{
  private $anythingImported = false;
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'import:categories';
  
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Import Categories from Hydrofarm';
  
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
   * @param HydroCategoryRepository $hydroCategoryRepository
   * @return void
   * @throws Exception
   */
  public function handle(HydroCategoryRepository $hydroCategoryRepository)
  {
    $this->alert('Importing Categories from Hydrofarm');
    $startTime = microtime(true);
    $hydroCategoryRepository->import(function(HydroCategory $hydroCategory) {
      $this->info("{$hydroCategory->name} imported from Hydrofarm");
      $this->anythingImported = true;
    });
    if(!$this->anythingImported) {
      $this->info('Already up-to-date');
    } else {
      $endTime = microtime(true);
      $totalTimeSpent = number_format($endTime - $startTime, 2);
      $this->alert("Categories imported in {$totalTimeSpent} seconds");
    }
  }
}
