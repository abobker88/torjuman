<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Driver;
use App\Models\Vehicle;
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
        // Driver::factory()
        //     ->times(50)
        //     ->create();
    $this->call(rolleSeeder::class);
    $this->call(UserSeeder::class);
    $this->call(ServiceSeeder::class);
    $this->call(OrderSeeder::class);

        // Vehicle::factory()
        // ->times(50)
        // ->create();


            // Bank::factory()
            // ->times(7)
            // ->create();
        // \App\Models\User::factory(10)->create();
    }

   

    
    
}
