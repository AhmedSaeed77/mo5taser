<?php

namespace App\Http\Controllers\Site\Subscribe;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\CourseRepositoryInterface;

class SubscribeController extends Controller
{

    private $course;

    public function __construct(CourseRepositoryInterface $course)
    {
        $this->course = $course;
    }

    public function CourseSubscribe(Request $request)
    {
        $coupon_val = $request->coupon;
        $course_id = $request->course_id;
        try
        {
            $coupon = Coupon::where(['coupon' => $coupon_val,'course_id' => $course_id])->first();
            if(isset($coupon) && $coupon->use_number > 0)
            {
               $course = $this->course->getById($course_id);
               $course_price = $course->price_after ? $course->price_after : $course->price;
               $cart = Cart::where(['course_id' => $course->id , 'user_id' => auth()->id()])->first();
               if(isset($cart))
               {
                    $cart->update([
                        'price' => $coupon->discount ? round($course_price - ($coupon->discount / 100 * $course_price)) : round($course_price - $coupon->discount_number),
                        'coupon' => $coupon->coupon,
                        'difference' => $coupon->discount ? round($coupon->discount / 100 * $course_price) : $coupon->discount_number,
                    ]);
                    $coupon->use_number--;
                    $coupon->save();
               }

                $result = view('site.cart.content_cart_row')->render();
                $result2 = view('site.cart.content_header')->render();
                return response()->json(['msg' => __('lang.coupon_activated'), 'result' => $result , 'result2' => $result2, 'status' => 200]);
            }
            else
            {
                return response()->json(['msg' =>  __('lang.not_found_coupon'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['msg' =>  __('lang.not_found'),'status' => 400]);
        }
    }



}
