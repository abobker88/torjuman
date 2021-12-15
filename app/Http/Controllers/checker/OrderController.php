<?php

namespace App\Http\Controllers\checker;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderChecker;
use App\Models\OrderTranslator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function listOrder(Request $request)
    {
        $orders = OrderChecker::where('checker_id', Auth::id())->with('order.service')->whereHas('order',function($q){
            $q->where('status','uc');
        })->with('order.user')->get();

         $data = [
              'category_name' => 'datatable',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('checker.order', compact('orders'))->with($data);
    }


    public function approve(Request $request)
    {
        if($request->order_id)
        {
            $order=Order::whereId($request->order_id)->first();

            $order->status='c'; //approved by checker 

            $order->save();

            $order_checker=OrderChecker::where('order_id',$order->id)->first();

            $order_checker->status='ap';

            $order_checker->save();

            $translator_order=OrderTranslator::where('order_id',$request->order_id)->first();
            
            
            $translator_order->status='complete';
            $translator_order->save();

            return ['success' => true, 'message' => 'order updated !!'];
        }
    }
        public function listOrderChecked(Request $request)
    {
        $orders = OrderChecker::where('checker_id', Auth::id())->with('order.service')->whereHas('order',function($q){
            $q->where('status','c');
        })->with('order.user')->where('status','ap')->get();

         $data = [
              'category_name' => 'datatable',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('checker.checked_order', compact('orders'))->with($data);
    }


    public function comment(Request $request)
    {
        if($request->order_id)
        {
           // $customer_service = User::role('customer service')->first();
           $order_check=OrderChecker::where('order_id',$request->order_id)->first();
           $order_check->status='fix';// refixed
           $order_check->comment=$request->comment;
           $order_check->save();
          
            return ['success' => true, 'message' => 'order updated !!'];
        }
    }

    
}
