<?php
namespace App\Traits;
use App\Models\DeviceToken;
use Carbon\Carbon;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;

Trait NotificationTrait
{


    function sendMultiNotification($notificationTitle, $notificationBody, $devicesTokens) {

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($notificationTitle);
        $notificationBuilder->setBody($notificationBody)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
//        dd($dataBuilder);
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

// You must change it to get your tokens
        $tokens = $devicesTokens;

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
//        dd($downstreamResponse);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

//return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

//return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

//return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array
        $downstreamResponse->tokensWithError();

        return ['success' => $downstreamResponse->numberSuccess(), 'fail' => $downstreamResponse->numberFailure()];
    }

    function saveNotification($userId,$type=null , $value_ar,$value_en,$title_ar,$title_en,$icon=null, $order_id = 0 ) {

        $notification = \App\Models\Notification::create(
            [
                'user_id'        => $userId,
                'type'           => $type,
                'value_ar'        => $value_ar,
                'value_en'        => $value_en,
                'title_ar'        => $title_ar,
                'title_en'        => $title_en,
                'icon'        => $icon,
                'order_id'    => $order_id,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        return $notification;
    }
    public function notification($title, $body, $to)
    {
        $firebase_key = 'AAAA4f07Glc:AAAAm-7Olqw:APA91bF8Z8vIzUGRbQu7aLAb5eVQVWHORU7E6TD-deSZARlreUK92j5fK5VcyRZ6kvNnheMRRFlrfJd6HQv4LWiRpK6W3MBQdnax8mJpaYBKp4n5L9LA-0HZ-2pLjxl60yHJu4uYEewy';
        $dataArr = array(
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'status'=>"done",
            'screen'=>'two'
        );
        $notification = array(
            'title' =>$title,
            'body' => $body,
            'sound' => 'default',
            'badge' => '1',
        );
        $arrayToSend = array(
            'to' => $to,
            'notification' => $notification,
            'data' => $dataArr,
            'priority'=>'high'
        );
        $dataString = json_encode ($arrayToSend);
        $headers = [
            'Authorization: key=' . $firebase_key,
            'Content-Type:application/json',
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        dd($response);
    }

}


