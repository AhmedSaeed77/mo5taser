<?php

namespace App\Http\Controllers\Api\Notification;

use App\Models\Notification;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\NotificationResource;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        try
        {
            $user = JWTAuth::user();
            $notifications = $user->Notifications()->orderBy('id','desc')->get();
            return response()->json(['data' => NotificationResource::collection($notifications),'status' => 200]);

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        try
        {
            if(isset($notification))
            {
                $notification->update([
                    'read_at' => Carbon::now()->toDateTimeString()
                ]);
            }
            return response()->json(['data' => __('lang.readed_notification'),'status' => 200]);

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
