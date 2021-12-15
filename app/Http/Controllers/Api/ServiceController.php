<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\notificationModel;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends AppBaseController
{
    /**
     * 
    * @OA\Get(

        *  path="/api/services",
       
        *  operationId="forgot_password",
        *  tags={"Services"},
       
        *  summary="Get All Services ",
       
        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="User register"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */
    public function getAll()
    {
       $services=Service::all();
       $services->map(function($item){
        $item->icon=asset($item->icon);
        $item->background_icon=asset($item->background_icon);
    });
        return $this->sendResponse( $services, 'data load successfully');
    }


    /**
     * 
 * @OA\Get(

        *  path="/api/get_my_notification",
       
        *  operationId="my order",
        *  tags={"Order"},
       
        *  summary="get user notification ",
  * security={{"bearer_token":{}}},
   
       
    
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="get user notifications"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function getUserNotification()
    {
        $notifications=notificationModel::where('to_id',auth()->id())->whereIn('type',['message_from_translator','message_from_customer_service','order_status_change'])->orderBy('created_at', 'desc')->get();

        $notifications->map(function($item){
            $order=Order::find($item->order_id);
      
            switch($order->status){
                case 'n': 
                    $item->order_status='under review';
                    break;
                case 'ca': 
                    $item->order_status='cancel';
                    break;
                case 'p': 
                    $item->order_status='processing';
                    break;
                case 'up': 
                    $item->order_status='waiting customer to approve price';
                    break;
                case 'ap':
                    $item->order_status='processing';
                    break;
                case 'ur': 
                    $item->order_status='processing';
                    break;
                case 'c': 
                    $item->status='complete';
                    break;
                case 'a': 
                    $item->status='processing';
                    break;
                case 'uc': 
                    $item->order_status='processing';
                    break;
            }
        });
    
        
        return $this->sendResponse( $notifications, 'data load successfully');
    }


  /**
     * 
 * @OA\Get(

        *  path="/api/user/get_remain_words",
       
        *  operationId="my order",
        *  tags={"User"},
       
        *  summary="get user notification ",
  * security={{"bearer_token":{}}},
   
       
    
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="get remain balance"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function getRemain()
    {
        $user=User::whereId(auth()->id())->first();
        
        return $this->sendResponse( $user->remain_word, 'data load successfully');
    }
}
