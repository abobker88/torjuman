<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderChecker;
use App\Models\OrderTranslator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

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
            'orders_income'=>$orders_income,
            'order_translators'=>$order_check_by_translators
        ];
    
          return view('admin.dashboard')->with($data);
    }

    public function translator(Request $request)
    {
        
            $orders = OrderTranslator::with(['order.service','translator'])->whereHas('order',function($q){ 
            })->with('order.user')->withCount('order')->get();
    
        
             $data = [
                  'category_name' => 'datatable',
                  'page_name' => 'orders_page',
                  'has_scrollspy' => 0,
                  'scrollspy_offset' => '',
              ];
      
             return view('admin.translator', compact('orders'))->with($data);
        
    }


    public function profile(Request $request)
    {

        $user = User::find(Auth::id());

        $data = [
            'category_name' => '',
            'page_name' => 'orders_page',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('admin.profile',compact('user'))->with($data);

    }


    public function submitProfile(Request $request)
    {
        $user = User::find(Auth::id());
        

        $user->name=$request->name;
        $user->email=$request->email;
        if($request->password)
        $request->password=bcrypt($request->password);

        $user->save();

        Flash::success('profile updated !');

        return redirect(route('myProfile'));
    }

}
