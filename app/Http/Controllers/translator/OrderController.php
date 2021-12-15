<?php

namespace App\Http\Controllers\translator;

use App\Http\Controllers\Controller;
use App\Models\notificationModel;
use App\Models\Order;
use App\Models\OrderCancel;
use App\Models\OrderChecker;
use App\Models\OrderTranslator;
use App\Models\TranslationChat;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    

         public function index(Request $request)
         {

          

           $orders=Order::where('status','n')->with('user')->whereHas('service',function($q){
               $q->whereIn('id',[1,2]);
           })->get();

            $order_accept=OrderTranslator::where('user_id',Auth::id())->where('status','accept')->first();
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
     
            return view('translator.order.index', compact('orders','check_accept'))->with($data);

         }


         public function accept(Request $request)
         {
             if($request->order_id)
             {
                 $order=Order::whereId($request->order_id)->first();

                 $order->status='a'; //accept by translator 

                 $order->save();

                 OrderTranslator::create([
                     'order_id'=>$request->order_id,
                     'user_id'=>Auth::id(),
                     'status'=>'accept'
                 ]);

                 return ['success' => true, 'message' => 'order updated !!'];
             }
         }


         public function listAccepted(Request $request)

         {
            $orders = OrderTranslator::where('user_id', Auth::id())->with('order.service')->whereHas('order',function($q){
                $q->where('status','a')->orWhere('status','up');
            })->with('order.user')->get();

             $data = [
                  'category_name' => 'datatable',
                  'page_name' => 'orders_page',
                  'has_scrollspy' => 0,
                  'scrollspy_offset' => '',
              ];
      
             return view('translator.order.accept', compact('orders'))->with($data);
         }


         public function cancel(Request $request)
        {
            if($request->order_id)
            {
                $customer_service = User::role('customer service')->first();
                OrderCancel::create([
                    'order_id'=>$request->order_id,
                    'translator_id'=>Auth::id(),
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

        public function download(Request $request)
        {
           
            if($request->order_id)
            {
                $order=Order::find($request->order_id);
                $url=asset($order->document_url);
                $file = basename($url); 
                return ['success' => true, 'data' => $url,'file'=>$file];
            }
        }

        public function downloadTranslation(Request $request)
        {
           
            if($request->order_id)
            {
                $order=Order::find($request->order_id);
                $url=asset($order->translation_url);
                $file = basename($url); 
                return ['success' => true, 'data' => $url,'file'=>$file];
            }
        }
        
        
        public function upload(Request $request)
        {
       
            $order=Order::find($request->order_id);
        
                if($request->hasFile('file')) {
                $file = $request->file('file');
     
                //you also need to keep file extension as well
                $name = $request->file('file')->getClientOriginalName();
                  $order_status='';
                
                if(Route::currentRouteName()=='translator.upload')
                {
                    $order_status='uc';
                } else {
                    $order_status='c';
                }
                $file->move(public_path().'/files/', $name);
                $order->translation_url= 'files/'. $name;
                $order->status=$order_status;//under check
                $order->save();
                $checker = User::role('checker')->first();
                if($order_status=='uc'){
                 OrderChecker::create([
                     'checker_id'=>$checker->id,
                     'translator_id'=>Auth::id(),
                     'status'=>'n',//new,
                     'order_id'=>$request->order_id
                 ]);   
                }
                return ['success' => true, 'message' => 'uploaded'];
             }

        }

        public function ReUpload(Request $request)
        {
       
            $order=Order::find($request->order_id);
           
                if($request->hasFile('file')) {
                $file = $request->file('file');
     
                //you also need to keep file extension as well
                $name = $file->getClientOriginalName();
     
                
                $file->move(public_path().'/files/', $name);
                $order->translation_url= 'files/'. $name;
                $order->save();
                $checker = User::role('checker')->first();
                 OrderChecker::where('order_id',$order->id)->update([
                     'status'=>'n',//new,
                     'comment'=>null

                 ]);   
                return ['success' => true, 'message' => 'uploaded'];
             }

        }
        

        public function listChecked(Request $request)
        {
            $orders = OrderChecker::where('translator_id', Auth::id())->with('order.service')->whereHas('order',function($q){
                $q->where('status','uc');
            })->with('order.user')->get();

             $data = [
                  'category_name' => 'datatable',
                  'page_name' => 'orders_page',
                  'has_scrollspy' => 0,
                  'scrollspy_offset' => '',
              ];
      
             return view('translator.order.under_check', compact('orders'))->with($data);
        }


        public function chat(Request $request)
        {
            $chats=TranslationChat::where('order_id',$request->order_id)->get();

            $user=User::find($request->user_id);
            $order=Order::find($request->order_id);
            $data = [
                'category_name' => 'datatable',
                'page_name' => 'chat',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
            ];
    
           return view('translator.chat',compact('chats','user','order'))->with($data);
        }


        public function submitChat(Request $request)
        {
            if($request->user_id)
            {
                $chat= new TranslationChat();
  
              $chat->translator_id=Auth::id();
              $chat->message=$request->message;
              $chat->message_from='translator';
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
