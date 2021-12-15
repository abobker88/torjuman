<?php

namespace App\Http\Controllers\checker;

use App\Http\Controllers\Controller;
use App\Models\OrderChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //


    public function dashboard(Request $request)
    {
         $result=[];
    
      
        $orders = OrderChecker::where('checker_id', Auth::id())->count();
        $orders_accept = OrderChecker::where('checker_id', Auth::id())->where('status','ap')->count();
     
        $data = [
            'category_name' => '',
            'page_name' => 'analytics',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'orders'=>$orders,
            'orders_accept'=>$orders_accept,
        ];
    
          return view('checker.dashboard')->with($data);
    }
}
