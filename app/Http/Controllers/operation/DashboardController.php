<?php

namespace App\Http\Controllers\operation;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //


    public function dashboard(Request $request)
    {
         $result=[];
    
      
        $orders = OrderOperation::where('user_id', Auth::id())->count();
        $orders_accept = OrderOperation::where('user_id', Auth::id())->where('status','accept')->count();
     
        $data = [
            'category_name' => '',
            'page_name' => 'analytics',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'orders'=>$orders,
            'orders_accept'=>$orders_accept,
        ];
    
          return view('operation.dashboard')->with($data);
    }
}
