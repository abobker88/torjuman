<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderChecker;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //


    public function dashboard(Request $request)
    {
         $result=[];
        $end_users=User::role('end_user')->get()->count();
        $users_have=User::role('end_user')->has('order')->get()->count();
        $orders=Order::get()->count();
        $order_complete=Order::where('status','c')->get()->count();
        $order_cancel=Order::where('status','ca')->get()->count();
        $order_new=Order::where('status','n')->get()->count();
        $order_check_by_translators=OrderChecker::where('status','ap')->count();
        $orders_income=Order::where('status','c')->sum('total_amount');
        $orders_vat=Order::where('status','c')->sum('vat_value');
        $orders_net=Order::where('status','c')->sum('sub_total');
        $data = [
            'category_name' => '',
            'page_name' => 'analytics',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'end_users'=>$end_users,
            'users_have'=>$users_have,
            'orders'=>$orders,
            'order_complete'=>$order_complete,
            'order_cancel'=>$order_cancel,
            'order_new'=>$order_new,
            'orders_vat'=>$orders_vat,
            'orders_net'=>$orders_net,
            'orders_income'=>$orders_income,
            'order_translators'=>$order_check_by_translators
        ];
    
          return view('accounting.dashboard')->with($data);
    }
}
