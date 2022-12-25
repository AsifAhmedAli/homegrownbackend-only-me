<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use TCG\Voyager\Models\Role;

class CreateDevUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Developer';

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
      if (Schema::hasTable('users')) {
        $user = new User;
        $devRole = Role::where('name', 'like', '%developer%')->first();
        if($devRole) {
          $user->role_id = $devRole->id;
        }
        $user->name = 'Developer';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('123456');
        $user->save();
        $this->info("Developer Created Successfully!");
      }
    }
}
