<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create();
  
      for($i = 0; $i < 100; $i++) {
        App\User::create([
          'name'     => $faker->name,
          'email'    => $faker->email,
          'password' => bcrypt('123456')
        ]);
      }
        // $this->call(UserSeeder::class);
    }
}
