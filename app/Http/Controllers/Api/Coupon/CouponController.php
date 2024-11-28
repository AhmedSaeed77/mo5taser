<?php

namespace App\Http\Controllers\Api\Coupon;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Http\Resources\ModelCollection;
use App\Repository\CouponRepositoryInterface;
use App\Repository\CourseRepositoryInterface;

class CouponController extends Controller
{
    private $coupon ,$course;

    public function __construct(CouponRepositoryInterface $coupon,CourseRepositoryInterface $course)
    {
        $this->coupon = $coupon;
        $this->course = $course;
    }

    public function index()
    {
        try
        {
            $coupons = Coupon::where(['user_id' => JWTAuth::user()->id])->get();
            return response()->json(['data' => CouponResource::collection($coupons),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function getCoupon($course_id,$coupon)
    {
        $coupon = Coupon::where(['coupon' => $coupon])->first();
        $course = $this->course->getById($course_id);
        try
        {
            if($coupon && $course && $coupon->course_id == $course_id)
            {
                return response()->json(['data' => new CouponResource($coupon),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found_coupon'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
