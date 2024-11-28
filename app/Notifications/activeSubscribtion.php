<?php

namespace App\Notifications;

use App\Models\Subscribe;
use App\Models\User;
use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class activeSubscribtion extends Notification
{
    use Queueable;
    protected $subscribe;
    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toArray($notifiable)
    {

        $user = User::where('id',$this->subscribe->user_id)->first();
        $course = Course::where('id',$this->subscribe->course_id)->first();
        $to= $user->google_device_token;
        $message_ar = [
            "title"=>"لديك اشعار جديد",
            "body"=>" تم  تفعيل اشتراك  ". $course->title_ar ,
            ];
        $message_en = [
            "title"=>"You have new notification",
            "body"=>"  Course subscribtion activated  ". $course->title_en ,
            ];
            $fields = array(
                'to'   => $to,
                "notification" => app()->getLocale() == 'ar' ? $message_ar : $message_en,
                'data' => app()->getLocale() == 'ar' ? $message_ar : $message_en
            );

            // Set POST variables
            $url = 'https://fcm.googleapis.com/fcm/send';
            // Open connection
            $ch = curl_init();
            // Set the url, number of POST vars, POST data
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; ',
                            'Authorization: key = AAAAuG3zZOI:APA91bFPY2phEKBmR8-s19b-ExIYDMP5rvFp3jyFf0OaucLoqaCjxR3LIPiiL20Nm6PqJ2Z-x8cN4wPdIJFlb6PpLa0WKuxMdFn8a3lXwVG_4hxgTu4T0QRY-MUpkj_KN6XQspUcCr6h'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            // Disabling SSL Certificate support temporarly
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
            // Execute post
            $result = curl_exec( $ch );
            if ( $result === false ) {
                die( 'Curl failed: ' . curl_error( $ch ) );
            }
            // Close connection
            curl_close( $ch );
            // end clinic notification

        return [
             'user_id' => $this->subscribe->user_id,
             'course_id' => $this->subscribe->course_id,
             'type' => 'activate_subscribtion',
        ];
    }
}
