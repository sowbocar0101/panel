<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
use App\Http\Controllers\NotificationController;

class Api extends Model
{

    // Notification API function
    public static function sendNotification($tokens, $message, $data){
        $fcm_key = config('api.fcm_key');

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' 	=> $tokens,
            'notification' => $message,
            //'data'=>$data,
            'content_available' => true,
            'priority' => 'high',
            //'body'=>$data
        );

        $headers = [
            'Authorization: key='.$fcm_key,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}