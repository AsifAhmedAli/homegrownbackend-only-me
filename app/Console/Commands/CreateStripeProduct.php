<?php

namespace App\Console\Commands;

use App\Exceptions\Response\ErrorResponseException;
use App\Repositories\Stripe\StripeProductRepository;
use Illuminate\Console\Command;
use Stripe\Exception\ApiErrorException;

class CreateStripeProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:product {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Product for Stripe';
  
    /**
     * CreateStripeProduct constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
  
    /**
     * @param StripeProductRepository $stripeProductRepository
     * @throws ErrorResponseException
     */
    public function handle(StripeProductRepository $stripeProductRepository)
    {
      $created = $stripeProductRepository->createProduct($this->argument('name'));
      
      if ($created) {
        $this->info('Product created Successfully!');
      } else {
        $this->error('Product already exists with same name');
      }
    }
}
