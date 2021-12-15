<?php

namespace App\Http\Controllers\operation;

use App\Http\Controllers\Controller;
use App\Models\notificationModel;
use App\Models\Order;
use App\Models\OrderChecker;
use App\Models\OrderOperation;
use App\Models\OrderOperationCancel;
use App\Models\TranslationChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //


    public function listOrder(Request $request)
    {
        $orders=Order::where('status','n')->with('user')->whereHas('service',function($q){
            $q->whereIn('id',[1,2]);
        })->get();
        $order_accept=OrderOperation::where('user_id',Auth::id())->where('status','accept')->first();
        $check_accept=true;
        if($order_accept)
        {
              $check_accept=false;
        }
         $data = [
              'category_name' => 'datatable',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('operation.order.index', compact('orders','check_accept'))->with($data);
    }

    public function accept(Request $request)
    {
        if($request->order_id)
        {
            $order=Order::whereId($request->order_id)->first();

            $order->status='a'; //accept by operation 

            $order->save();

            OrderOperation::create([
                'order_id'=>$request->order_id,
                'user_id'=>Auth::id(),
                'status'=>'accept'
            ]);

            return ['success' => true, 'message' => 'order updated !!'];
        }
    }

    public function listAccepted(Request $request)

         {
            $orders = OrderOperation::where('user_id', Auth::id())->with('order.service')->whereHas('order',function($q){
                $q->where('status','a')->orWhere('status','up');
            })->with('order.user')->get();

             $data = [
                  'category_name' => 'datatable',
                  'page_name' => 'orders_page',
                  'has_scrollspy' => 0,
                  'scrollspy_offset' => '',
              ];
      
             return view('operation.order.accept', compact('orders'))->with($data);
         }

         public function cancel(Request $request)
         {
             if($request->order_id)
             {
                 $customer_service = User::role('customer service')->first();
                 OrderOperationCancel::create([
                     'order_id'=>$request->order_id,
                     'operation_id'=>Auth::id(),
                     'customer_service_id'=>$customer_service->id,
                     'reason'=>$request->reason,
                     'status' =>'n'
                 ]);
                $order=Order::find($request->order_id);
                $order->status='ur';//under review
                $order->save();
                 return ['success' => true, 'message' => 'order updated !!'];
             }
         }

         public function  listCheckOrder(Request $request)
         {
             
            $orders = OrderChecker::with('order.service')->whereHas('order',function($q){
                $q->where('status','uc');
            })->with('order.user')->get();
    
             $data = [
                  'category_name' => 'datatable',
                  'page_name' => 'orders_page',
                  'has_scrollspy' => 0,
                  'scrollspy_offset' => '',
              ];
      
             return view('operation.checker_order', compact('orders'))->with($data);
         }

         public function  listCompleteOrder(Request $request)
         {
             
            $orders = OrderOperation::with('order.service')->whereHas('order',function($q){
                $q->where('status','c');
            })->with('order.user')->get();
    
             $data = [
                  'category_name' => 'datatable',
                  'page_name' => 'orders_page',
                  'has_scrollspy' => 0,
                  'scrollspy_offset' => '',
              ];
      
             return view('operation.order.complete', compact('orders'))->with($data);
         }

         public function approve(Request $request)
    {
        if($request->order_id)
        {
            $order=Order::whereId($request->order_id)->first();

            $order->status='c'; //approved by operation 

            $order->save();

            $order_checker=OrderChecker::where('order_id',$order->id)->first();

            $order_checker->status='ap';

            $order_checker->save();

            return ['success' => true, 'message' => 'order updated !!'];
        }
    }


    public function chat(Request $request)
        {
            $chats=TranslationChat::where('user_id',$request->user_id)->where('message_from','operation')->get();
            $user=User::find($request->user_id);
            $order=Order::find($request->order_id);
           
            $data = [
                'category_name' => 'datatable',
                'page_name' => 'chat',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
            ];
    
           return view('operation.chat',compact('chats','user','order'))->with($data);
        }


        public function submitChat(Request $request)
        {
            if($request->user_id)
            {
                $chat= new TranslationChat();
  
              $chat->translator_id=Auth::id();
              $chat->message=$request->message;
              $chat->message_from='operation';
              $chat->user_id=$request->user_id;
              $chat->order_id=$request->order_id;
              $chat->save();


              notificationModel::create([
                'order_id'=>$request->order_id,
                'to_id'=>$request->user_id,
                'type'=>'message_from_translator',
                'content'=>'there new message'
            ]); 
              return ['success' => true, 'message' => 'uploaded'];
            }
        }

 
}
