<?php

namespace App\Http\Controllers\Api\Cart;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Privacy;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Http\Resources\CartResource;
use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\ModelCollection;
use App\Repository\BankRepositoryInterface;
use App\Repository\CartRepositoryInterface;
use App\Repository\CourseRepositoryInterface;
use App\Http\Requests\Cart\ApplyCouponRequest;

class CartController extends Controller
{
    private $cart,$course;

    public function __construct(CartRepositoryInterface $cart,CourseRepositoryInterface $course)
    {
        $this->cart = $cart;
        $this->course = $course;
    }

    public function index()
    {
        try
        {
            $carts = Cart::where('user_id',JWTAuth::user()->id)->get();
            $total =  array_sum($carts->pluck('price')->toArray());
            return response()->json(['data' => new ModelCollection(CartResource::collection($carts)) , 'total' => $total,'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function addToCart(CartRequest $request)
    {
        $course = $this->course->getById($request->id);
        try
        {
            if(isset($course))
            {
                $carts = Cart::where('user_id', JWTAuth::user()->id)->get();
                $subscribe = Subscribe::where(['course_id' => $course->id, 'user_id' => JWTAuth::user()->id])->first();
                if($subscribe && $subscribe->start_subscribe == NULL && $subscribe->end_subscribe == NULL)
                {
                    return response()->json(['data' => __('lang.course_wait_activation'),'status' => 400]);
                }
                if($subscribe && $subscribe->active == 1)
                {
                    return response()->json(['data' => __('lang.already_subscribed'),'status' => 400]);
                }


                if(in_array($course->id,$carts->pluck('course_id')->toArray()))
                {
                    return response()->json(['data' => __('lang.course_cart_exist'),'status' => 400]);
                }
                else
                {
                    $cart = new Cart;
                    $cart->user_id = JWTAuth::user()->id;
                    $cart->course_id = $course->id;
                    $cart->price = $course->price_after ? $course->price_after : $course->price;
                    $cart->save();

                    return response()->json(['data' => __('lang.added_to_cart'),'status' => 200]);
                }
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function removeFromCart(CartRequest $request)
    {
        $cart = Cart::where(['id' => $request->id ,'user_id' => JWTAuth::user()->id])->first();
        try
        {
            if($cart)
            {
                $cart->delete();
                return response()->json(['data' => __('lang.removed_from_cart'),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found_content'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function deleteCart()
    {
        $items = Cart::where(['user_id' => JWTAuth::user()->id])->get();
        try
        {
            if($items->count() > 0)
            {
                foreach($items as $item)
                {
                    $item->delete();
                }
                return response()->json(['data' => __('lang.deleted'),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found_content'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }


    public function applyCoupon(ApplyCouponRequest $request)
    {
        try
        {
            $coupon = Coupon::where(['coupon' => $request->coupon,'course_id' => $request->course])->first();
            if(isset($coupon))
            {
               $course = $this->course->getById($request->course);
               $course_price = $course->price_after ? $course->price_after : $course->price;
               $cart = Cart::where(['course_id' => $course->id , 'user_id' => JWTAuth::user()->id])->first();
               if(isset($cart))
               {
                    $cart->update([
                        'price' => $coupon->discount ? round($course_price - ($coupon->discount / 100 * $course_price)) : round($course_price - $coupon->discount_number),
                        'coupon' => $coupon->coupon,
                        'difference' => $coupon->discount ? round($coupon->discount / 100 * $course_price) : $coupon->discount_number,
                    ]);
               }

                return response()->json(['data' => new CartResource($cart) , 'status' => 200]);
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
