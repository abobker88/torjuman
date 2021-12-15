<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderTranslator;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
for($i=0;$i<10;$i++){
    $order=Order::create([
        'user_id'=>7,
        'service_id'=>rand(1,5),
        'status'=>'n',
        'total_amount'=>$i*20,
        'date'=>Carbon::today(),
        'document_url'=>'files/ترجمان تحليل.pdf'
    ]);
}
      

      
        
    }
}
