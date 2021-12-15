<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class rolleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        
        Role::create(['name' => 'operation manager']);
        Role::create(['name' => 'translator']);
        Role::create(['name' => 'checker']);
        Role::create(['name' => 'customer service']);
        Role::create(['name' => 'accounting']);
        Role::create(['name' => 'end_user']);
    }
}
