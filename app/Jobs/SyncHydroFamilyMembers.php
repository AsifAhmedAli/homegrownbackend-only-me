<?php

namespace App\Jobs;

use App\Hydro\HydroProduct;
use App\Repositories\Hydro\HydroProductRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncHydroFamilyMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $hydroProducts;
  
    /**
     * Create a new job instance.
     *
     * @param HydroProduct[] $hydroProducts
     */
    public function __construct($hydroProducts)
    {
        $this->hydroProducts = $hydroProducts;
    }
  
  /**
   * Execute the job.
   *
   * @param HydroProductRepository $hydroProductRepository
   * @return void
   * @throws Exception
   */
    public function handle(HydroProductRepository $hydroProductRepository)
    {
      $hydroProductRepository->syncFamilyMembers($this->hydroProducts);
    }
}
