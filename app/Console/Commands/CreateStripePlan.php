<?php

namespace App\Console\Commands;

use App\Exceptions\Response\ErrorResponseException;
use App\Repositories\Stripe\StripePlanRepository;
use Illuminate\Console\Command;

class CreateStripePlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:plan {name} {amount} {currency} {interval} {--productID=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Stripe Plan';

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
   * @param StripePlanRepository $stripePlanRepository
   * @throws ErrorResponseException
   */
    public function handle(StripePlanRepository $stripePlanRepository)
    {
        $stripePlanRepository->setValues(
          $this->argument('name'),
          $this->argument('amount'),
          $this->argument('currency'),
          $this->argument('interval'),
          $this->option('productID')
        );
        
        $created = $stripePlanRepository->createPlan();
        
        if ($created) {
          $this->info('Plan Created Successfully');
        } else {
          $this->error('Something went wrong');
        }
    }
}
