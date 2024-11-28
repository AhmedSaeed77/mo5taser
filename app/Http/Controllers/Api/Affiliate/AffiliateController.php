<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Models\Info;
use App\Models\Coupon;
use App\Models\Exchange;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\ExchangesResource;
use App\Http\Resources\AffilateSubscribeResource;

class AffiliateController extends Controller
{
    public function index()
    {
        try
        {
            $coupons = Coupon::where('user_id',JWTAuth::user()->id)->get();
            $subscribes = Subscribe::whereIn('coupon' , $coupons->pluck('coupon')->toArray())->get();
            $incomming_profits = array_sum(Subscribe::where(['user_id' => JWTAuth::user()->id, 'active' => 0 , 'start_subscribe' => NULL , 'end_subscribe' => NULL])->get()->pluck('difference')->toArray());
            $info = Info::first();
            $exchanges = Exchange::where('user_id' , JWTAuth::user()->id)->get();


            return response()->json(['data' =>[
            'subscribes' => AffilateSubscribeResource::collection($subscribes),
            'exchanges' => ExchangesResource::collection($exchanges),
            'min_profit' => $info->min_profit ?? 0,
            'incomming_profits' => $info->incomming_profits ?? 0,
            'exchangeable_profits' => auth()->user()->balance,
            ]
            ,'status' => 200]);

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
