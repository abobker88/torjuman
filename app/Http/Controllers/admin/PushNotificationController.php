<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use App\Traits\NotificationTrait;

class PushNotificationController extends Controller
{


  use NotificationTrait;
    public function create()
    {
        $users = User::role('end_user')->get();

        $data = [
            'category_name' => '',
            'page_name' => 'orders_page',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('admin.push_notification.create',compact('users'))->with($data);
    }

    public function notifyUser(Request $request){
 
        if($request->has('user_id')){

            $users = User::whereIn('id', $request->user_id)->get();
        } else {
          //  $user = User::where('approval_state', DriverApproval::Approved)->get();


        }
    
      foreach($users as $user)
      {
        $token=DeviceToken::where('user_id',$user->id)->first();

         $this->sendMultiNotification('Notification', $request->message, $token->fcm_token);

   
      //  $res = send_notification_FCM($notification_id, $title, $message, $id,$type);
   
      }
    
      
      
      Flash::success('Message Sending !');

      return redirect(route('admin.push_notification'));
      
     }



}
