<?php

namespace App\Console\Commands;

use App\Hydro\HydroCategory;
use App\Repositories\Hydro\HydroCategoryRepository;
use App\Repositories\Hydro\HydroProductRepository;
use Illuminate\Console\Command;
use Exception;

class ImportHydroProducts extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'import:products {category?} {--sync}';
  
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Import Products from Hydrofarm';
  
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
   * @param HydroProductRepository $hydroProductRepository
   * @throws Exception
   */
  public function handle(HydroProductRepository $hydroProductRepository)
  {
    $startTime = microtime(true);
    ini_set('memory_limit', -1);
    ini_set('max_execution_time', -1);
    $hydroProductRepository->setSync($this->option('sync'));
    if($this->argument('category')) {
      $category = HydroCategoryRepository::find((int)$this->argument('category'));
      $this->alert('Importing Products from Hydrofarm for ' . $category->name);
      $hydroProductRepository->importViaCategory($category, function(HydroCategory $hydroCategory) {
        $this->info("{$hydroCategory->name}'s Products imported\n");
      }, 0, false);
    } else {
      $this->alert('Importing Products from Hydrofarm');
      $hydroProductRepository->import(function(HydroCategory $hydroCategory) {
        $this->info("{$hydroCategory->name}'s Products imported\n");
      });
    }
    $endTime = microtime(true);
    $totalTimeSpent = number_format($endTime - $startTime, 2);
    $this->alert("Products imported in {$totalTimeSpent} seconds");
  }
}
