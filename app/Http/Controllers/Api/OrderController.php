<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\checkOrderRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\DircetOrderRequest;
use App\Http\Requests\myOrderRequest;
use App\Http\Requests\OrderRequest;
use App\Mail\NotifyEmail;
use App\Models\CustomerServiceChat;
use App\Models\Order ;
use App\Models\OrderCancelByUser;
use App\Models\OrderTranslator;
use App\Models\Service;
use App\Models\TranslationChat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends AppBaseController
{
    //

 /**
     * 
    * @OA\Post(

        *  path="/api/order/create",
       
        *  operationId="create order",
        *  tags={"Order"},
       
        *  summary="Place Order ",
      * security={{"bearer_token":{}}},
         * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="file",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
           
               *  @OA\Parameter(
            *      name="service_id",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="integer"
            *      )
            *   ),

                *  @OA\Parameter(
            *      name="vat_value",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="double"
            *      )
            *   ),
                 *  @OA\Parameter(
            *      name="subtotal",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="double"
            *      )
            *   ),

                  *  @OA\Parameter(
            *      name="details",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),

        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="Order Placed"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */
    public function placeOrder(OrderRequest $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');
 
            //you also need to keep file extension as well
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/files/', $name);
            $service=Service::find($request->service_id);

          $order=new Order();
           $order->user_id=auth()->id();
           $order->service_id=$request->service_id;
         
           $order->total_amount=$service->price;
           $order->document_url='files/'. $name;
           $order->date=Carbon::today();
           $order->vat_value=$request->vat_value;
           $order->sub_total=$request->subtotal;
           $order->details=$request->details;

            if($service->id == 1 || $service->id == 2 )
            {
                $order->status='up';
                // send email to translators
            } else 
            {
                $order->status='n';
            }
           $order->save();

            switch($order->status){
                case 'n': 
                    $order->status='review';
                    break;
                case 'ca': 
                    $order->status='cancel';
                    break;
                case 'p': 
                    $order->status='processing';
                    break;
                case 'up': 
                    $order->status='waiting customer to approve price';
                    break;
                case 'ap':
                    $order->status='processing';
                    break;
                case 'ur': 
                    $order->status='processing';
                    break;
                case 'c': 
                    $order->status='complete';
                    break;
                case 'a': 
                    $order->status='processing';
                    break;
                case 'uc': 
                    $order->status='processing';
                    break;
            
           }
            return $this->sendResponse( $order, 'Order Created Successfully');

    }
    return $this->sendResponse( null,'no file');
    }


     /**
     * 
    * @OA\Get(

        *  path="/api/order/my_order",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="Get My Order ",
      * security={{"bearer_token":{}}},
       
       
        
       
        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="Orders"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */

public function getMyOrder(myOrderRequest $request)
{
    $orders_current=Order::with('service')->where('user_id',auth()->id())->whereIn('status',['n','p','up','ap','ur','uc'])->orderBy('created_at', 'desc')->get();
    $orders_current->map(function($item){
        $item->service_id=$item->service->id;
        $item->service=$item->service->name_ar;
        $item->document_url=asset($item->document_url);
        switch($item->status){
            case 'n': 
                $item->status='under review';
                break;
            case 'ca': 
                $item->status='cancel';
                break;
            case 'p': 
                $item->status='processing';
                break;
            case 'up': 
                $item->status='waiting customer to approve price';
                break;
            case 'ap':
                $item->status='processing';
                break;
            case 'ur': 
                $item->status='processing';
                break;
            case 'c': 
                $item->status='complete';
                break;
            case 'a': 
                $item->status='processing';
                break;
            case 'uc': 
                $item->status='processing';
                break;
        }
    });

    $orders_prev=Order::with('service')->where('user_id',auth()->id())->whereIn('status',['c','ca'])->orderBy('created_at', 'desc')->get();
    $orders_prev->map(function($item){
        $item->service_id=$item->service->id;
        $item->service=$item->service->name_ar;
        $item->document_url=asset($item->document_url);
        switch($item->status){
            case 'n': 
                $item->status='under review';
                break;
            case 'ca': 
                $item->status='cancel';
                break;
            case 'p': 
                $item->status='processing';
                break;
            case 'up': 
                $item->status='waiting customer to approve price';
                break;
            case 'ap':
                $item->status='processing';
                break;
            case 'ur': 
                $item->status='processing';
                break;
            case 'c': 
                $item->status='complete';
                break;
            case 'a': 
                $item->status='processing';
                break;
            case 'uc': 
                $item->status='processing';
                break;
        }
    });

    $my_orders=array('current_orders'=>$orders_current,'previous_order'=>$orders_prev);
  
    return $this->sendResponse( $my_orders, 'data load successfully');
}


    /**
     * 
    * @OA\Get(

        *  path="/api/order/check_order",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="Get My Order ",
      * security={{"bearer_token":{}}},
       
            *  @OA\Parameter(
            *      name="order_id",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="integer"
            *      )
            *   ),
        
       
        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="Orders"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */

public function checkOrder(checkOrderRequest $request)
{
   $order=Order::whereId($request->order_id)->first();
//    $orders->map(function($item){
//     $item->document_url=asset($item->document_url);
$order->document_url=asset($order->document_url);
$order->translation_url=asset($order->translation_url);
    switch($order->status){
        case 'n': 
            $order->status='review';
            break;
        case 'ca': 
            $order->status='cancel';
            break;
        case 'p': 
            $order->status='processing';
            break;
        case 'up': 
            $order->status='waiting customer to approve price';
            break;
        case 'ap':
            $order->status='processing';
            break;
        case 'ur': 
            $order->status='processing';
            break;
        case 'c': 
            $order->status='complete';
            break;
        case 'a': 
            $order->status='processing';
            break;
        case 'uc': 
            $order->status='processing';
            break;
    
   }
// });
    return $this->sendResponse($order, 'data load successfully');
}


    /**
     * 
 * @OA\Post(

        *  path="/api/order/direct_translation",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="make order and start chat with translator ",
  * security={{"bearer_token":{}}},
   
        *  @OA\Parameter(
        *      name="message",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),

        *  @OA\Parameter(
        *      name="service_id",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),
    
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="message sent and order created"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
public function directTranslation(DircetOrderRequest $request)
{

    $order=new Order();
    $order->user_id=auth()->id();
    $order->service_id=$request->service_id;
    $order->status='n';
    $order->total_amount=0;
    $order->document_url='no file';
    $order->date=Carbon::today();
    $order->save();
    $translator=User::role('translator')->first();
    OrderTranslator::create([
        'order_id'=>$order->id,
        'user_id'=>auth()->id()
    ]);
   $chat= new TranslationChat();
  
   $chat->translator_id=$translator->id;
   $chat->message=$request->message;
   $chat->message_from='user';
   $chat->user_id=auth()->id();
   $chat->order_id=$order->id;
   $chat->save();

   return $this->sendResponse($chat, 'data load successfully');
}



    /**
     * 
 * @OA\Post(

        *  path="/api/order/sent_to_customer_service",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="send to customer service ",
  * security={{"bearer_token":{}}},
   
        *  @OA\Parameter(
        *      name="message",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),

         *  @OA\Parameter(
        *      name="order_id",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),
    
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="message sent and order created"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function customerServiceChat(Request $request)
    {
        $chat_old=CustomerServiceChat::where('order_id',$request->order_id)->first();
        $customer_service_id=0;
        if($chat_old){
            $customer_service_id=$chat_old->customer_service_id;
        } else {
            $cs=User::role('customer service')->first();
            $customer_service_id=$cs->id;
        }
       $chat= new CustomerServiceChat();
        //$translator=User::role('customer service')->first();
       $chat->customer_service_id=$customer_service_id;
       $chat->message=$request->message;
       $chat->message_from='user';
       $chat->user_id=auth()->id();
       $chat->order_id=$request->order_id;
       $chat->save();
    
       return $this->sendResponse($chat, 'data load successfully');
    }



     /**
     * 
 * @OA\Get(

        *  path="/api/order/get_translation_chat",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="get chats with translator ",
  * security={{"bearer_token":{}}},
   
     

         *  @OA\Parameter(
        *      name="order_id",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),
    
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="get translation chat with user"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function translatorChat(Request $request)
    {
      
        $chats=TranslationChat::where('order_id',$request->order_id)->get();

        $order=Order::find($request->order_id);
$is_complete=false;
        if($order->status=='c')
        {
             $is_complete=true;
        }
        $data=array('chat_list'=>$chats,'is_order_completed'=>$is_complete);
        
       return $this->sendResponse($data, 'data load successfully');
    }


       /**
     * 
 * @OA\Get(

        *  path="/api/order/get_customer_service_chat",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="get chats with customer service ",
  * security={{"bearer_token":{}}},
   
     

         *  @OA\Parameter(
        *      name="order_id",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),
    
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="get translation chat with user"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function serviceChat(Request $request)
    {
  
       return $this->sendResponse(CustomerServiceChat::where('order_id',$request->order_id)->get(), 'data load successfully');
    }


    /**
     * 
 * @OA\Post(

        *  path="/api/order/sent_to_translator",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="send to translator ",
  * security={{"bearer_token":{}}},
   
        *  @OA\Parameter(
        *      name="message",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),

         *  @OA\Parameter(
        *      name="order_id",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),
    
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="message sent and order created"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function sendtoTranslatotChat(Request $request)
    {
        $chat_old=TranslationChat::where('order_id',$request->order_id)->first();
        $translator_id=0;
        if($chat_old)
        {
            $translator_id=$chat_old->translator_id;
        } else 
        {
            $translator=User::role('translator')->first();
            $translator_id=$translator->id;
        }
        $chat= new TranslationChat();
        $translator=User::role('customer service')->first();
       $chat->translator_id=$translator_id;
       $chat->message=$request->message;
       $chat->message_from='user';
       $chat->user_id=auth()->id();
       $chat->order_id=$request->order_id;
       $chat->save();
    
       return $this->sendResponse(TranslationChat::where('order_id',$request->order_id)->get(), 'data load successfully');
    }
    


 /**
     * 
    * @OA\Post(

        *  path="/api/order/free_trial_service",
       
        *  operationId="create order",
        *  tags={"Order"},
       
        *  summary="Place Order ",
      * security={{"bearer_token":{}}},
         * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="file",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
           
           

        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="Order Placed"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */
        public function freeOrder(OrderRequest $request)
        {
            if($request->hasFile('file')) {
                $file = $request->file('file');
     
                //you also need to keep file extension as well
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/files/', $name);
               // $service=Service::find($request->service_id);
    
               $order=new Order();
               $order->user_id=auth()->id();
               $order->service_id=8;
               $order->status='n';
               $order->total_amount=0;
               $order->document_url='files/'. $name;
               $order->date=Carbon::today();
               $order->save();
               $orders=Order::whereId($order->id)->get();
               $orders->map(function($item){
    
                switch($item->status){
                    case 'n': 
                        $item->status='new';
                    case 'ca': 
                        $item->status='cancel';
                    case 'p': 
                        $item->status='paid';
                    case 'up': 
                        $item->status='waiting customer to approve price';
                    case 'ap':
                        $item->status='approved';
                    case 'ur': 
                        $item->status='under review';
                    case 'c': 
                        $item->status='complete';
                    case 'a': 
                        $item->status='accepted';
                    case 'uc': 
                        $item->status='under check';
                    
            
                    
            
                }
            });
    
                return $this->sendResponse( $orders, 'Order Created Successfully');
    
        }
        return $this->sendResponse( null,'no file');
        }

/**
     * 
 * @OA\Post(

        *  path="/api/order/company_service",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="send to Company Form ",
  * security={{"bearer_token":{}}},
   
        *  @OA\Parameter(
        *      name="company_name",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),

         *  @OA\Parameter(
        *      name="representative",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),
          *  @OA\Parameter(
        *      name="email",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),

         *  @OA\Parameter(
        *      name="mobile",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),
               *  @OA\Parameter(
        *      name="description",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),
    
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="Form Sent"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */

        public function companyService(CompanyRequest $request)
        {
            
           
            try {
                $data = ['title' => 'the company information', 'company_name' => $request->company_name,'representative'=>$request->representative
               ,'email'=>$request->email,'mobile'=>$request->mobile,'description'=>$request->description
            ];
            Mail::To('bkry2010@live.com')->send(new NotifyEmail($data));

         
            return $this->sendSuccess( 'form sent successfully');
            
            } catch (\Exception $ex) {
                return $this->sendError($ex->getMessage());
            }

        }

/**
     * 
 * @OA\Post(

        *  path="/api/order/cancel_order",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="send to Company Form ",
  * security={{"bearer_token":{}}},
   
        *  @OA\Parameter(
        *      name="order_id",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),

      
    
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="order canceled"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
        public function cancelOrder(Request $request)
        {
              $order=Order::find($request->order_id);
              if($order)
              {
                $user=User::find($order->user_id);
                \Session::put('locale',$user->locale);
                \App::setLocale($user->locale);
                  if($order->status!='p' )
                  {
                      OrderCancelByUser::create([
                          'order_id'=>$request->order_id,
                          'user_id'=>auth()->id(),
                          'status'=>'n'
                      ]);
                      $order->status='ca';
                      $order->save();
                      return $this->sendSuccess( __('models/translator.order_cancel_successfully'));
                  } else {
                    return $this->sendError(  __('models/translator.order_paid_sent_to_customer_Service') );

                  }
              }
              return $this->sendError(  __('models/translator.order_not_found'));
        }



        /**
     * 
 * @OA\Post(

        *  path="/api/order/change_to_paid",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="change order to paid ",
  * security={{"bearer_token":{}}},
   
        *  @OA\Parameter(
        *      name="order_id",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),

      
    
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="order paid"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function paid(Request $request)
    {
          $order=Order::find($request->order_id);
          if($order)
          {
            $user=User::find($order->user_id);
            \Session::put('locale',$user->locale);
            \App::setLocale($user->locale);
              if($order->status!='p' )
              {
                
                  $order->status='p';
                  $order->save();
                  return $this->sendSuccess( __('models/translator.order_paid'));
              } else {
                return $this->sendError( __('models/translator.already_paid'));

              }
          }
          return $this->sendError( __('models/translator.order_not_found'));
    }

}
