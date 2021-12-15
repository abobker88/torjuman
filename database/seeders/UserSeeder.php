<?php

namespace Database\Seeders;

use App\Models\User;
use HashContext;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $admin= User::create([
           'name'=>'admin',
           'email'=>'admin@admin.com',
           'password'=>Hash::make('secret'), 
        ]);

        
        $admin->assignRole('admin');

        $op= User::create([
            'name'=>'operation manager',
            'email'=>'op@op.com',
            'password'=>Hash::make('secret'), 
         ]);
 
         $op->assignRole('operation manager');
        

         $translator= User::create([
            'name'=>'translator',
            'email'=>'translator@translator.com',
            'password'=>Hash::make('secret'), 
         ]);
 
         $translator->assignRole('translator');

         $checker= User::create([
            'name'=>'checker',
            'email'=>'checker@checker.com',
            'password'=>Hash::make('secret'), 
         ]);
 
         $checker->assignRole('checker');

         $customer_service= User::create([
            'name'=>'customer service',
            'email'=>'cs@cs.com',
            'password'=>Hash::make('secret'), 
         ]);
 
         $customer_service->assignRole('customer service');

         $accounting= User::create([
            'name'=>'accounting',
            'email'=>'acc@acc.com',
            'password'=>Hash::make('secret'), 
         ]);
 
         $accounting->assignRole('accounting');

         $end_user= User::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>Hash::make('secret'), 
         ]);
         $end_user->assignRole('end_user');
    }
}
