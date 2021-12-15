<?php

namespace App\Http\Controllers\customerService;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCancel;
use App\Models\OrderChecker;
use App\Models\OrderOperationCancel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //



    //list order to determine 


    public function listCancel(Request $request)
    {
        $orders = OrderCancel::where('customer_service_id', Auth::id())->with('order.service')->whereHas('order',function($q){
            $q->where('status','ur');
        })->with('order.user')->with('translator')->get();

         $data = [
              'category_name' => 'datatable',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('customer_service.order.cancel', compact('orders'))->with($data);
    }

    public function updatePrice(Request $request)
    {
          
         if($request->order_id)
         {
             
             $order=Order::find($request->order_id);
             $order->status='up'; // update price to user
             $order->total_amount=$request->new_price;
             $order->save();
             if(! Route::currentRouteName()=='customer_service.order.services')
             {
             OrderCancel::where('order_id',$order->id)->update([
                 'status'=>'p'
             ]);
            }
             return ['success' => true, 'message' => 'updated'];
         }
    }
    
    public function updatePriceOperation(Request $request)
    {
        if($request->order_id)
        {
            
            $order=Order::find($request->order_id);
            $order->status='up'; // update price to user
            $order->total_amount=$request->new_price;
            $order->save();
            
            OrderOperationCancel::where('order_id',$order->id)->update([
                'status'=>'p'
            ]);
           
            return ['success' => true, 'message' => 'updated'];
        }
    }
    public function listOrderUpdatePrice(Request $request)
    {
        $orders = OrderCancel::where('customer_service_id', Auth::id())->with('order.service')->whereHas('order',function($q){
            $q->where('status','up');
        })->with('order.user')->with('translator')->get();

         $data = [
              'category_name' => 'datatable',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('customer_service.order.updated_price', compact('orders'))->with($data);
    }

    public function listOrderSpecialPrice(Request $request)
    {
        $orders=Order::with('user')->whereHas('service',function($q){
            $q->whereIn('id',[3,4,6]);
        })->get();

         $data = [
              'category_name' => 'datatable',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('customer_service.order.services', compact('orders'))->with($data);
    }

    public function listOperationOrder(Request $request)
    {
        $orders = OrderOperationCancel::where('customer_service_id', Auth::id())->with('order.service')->whereHas('order',function($q){
            $q->where('status','ur');
        })->with('order.user')->with('operation')->get();

         $data = [
              'category_name' => 'datatable',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('customer_service.order.operation', compact('orders'))->with($data);
    }


        
    
}
