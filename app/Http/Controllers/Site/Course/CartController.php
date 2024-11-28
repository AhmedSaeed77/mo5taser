<?php

namespace App\Http\Controllers\Site\Course;

use App\Models\Cart;
use App\Models\Course;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try
        {
            $carts = Cart::query()->where('user_id', auth()->id())->get();
            $course = Course::where('id',$request->id)->first();
            $subscribe = Subscribe::where(['course_id' => $course->id, 'user_id' => auth()->id(), 'active' => 0])->first();
            if ($course->type == 'free') {
                return response()->json([ 'err' , __('lang.course_is_free')]);
            }
            // if($subscribe)
            // {
            //     return response()->json(['subscribtion_exist' , __('lang.course_wait_activation')]);
            // }

            if(in_array($course->id,$carts->pluck('course_id')->toArray()))
            {
                return response()->json([ 'exist' , __('lang.course_cart_exist')]);
            }
            else
            {
                $cart = new Cart;
                $cart->user_id = auth()->id();
                $cart->course_id = $course->id;
                $cart->price = $course->price_after ? $course->price_after : $course->price;
                $cart->save();

                $result = view('site.cart.content_header')->render();
                return response()->json(['added',$result]);
            }

        }
        catch(Exception $ex)
        {
            return response()->json([ 'err' , __('lang.not_found')]);
        }

    }

    //get cart getCartItems

    public function getCartItems()
    {
        try
        {
            return view('site.cart.checkout');
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    // remove items from cart

    public function destroy(Request $request,$id)
    {
        $cart = Cart::where('id',$id)->first();
        try
        {
            if(isset($cart))
            {
                $cart->delete();
                return back()->with('success' , __('lang.removed_from_cart'));
            }

        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function deleteCart()
    {
        try
        {
            $carts = Cart::get();
            if($carts->count() > 0)
            {
                foreach ($carts as $key => $item) {
                  $item->delete();
                }
            }
            return redirect()->back()->with('success' , __('lang.cart_deleted'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }



    public function BuyCourse(Request $request, $id)
    {
        try
        {
            $carts = Cart::get();
            $course = Course::where('id',$id)->first();
            dd($course);
            $subscribe = Subscribe::where(['course_id' => $course->id, 'user_id' => auth()->id(), 'active' => 0])->first();
            // if($subscribe)
            // {
            //     return response()->json(['subscribtion_exist' , __('lang.course_wait_activation')]);
            // }

            if(in_array($course->id,$carts->pluck('course_id')->toArray()))
            {
                return response()->json([ 'exist' , __('lang.course_cart_exist')]);
            }
            else
            {
                $cart = new Cart;
                $cart->user_id = auth()->id();
                $cart->course_id = $course->id;
                $cart->price = $course->price_after ? $course->price_after : $course->price;
                $cart->save();

                $result = view('site.cart.content_header')->render();
                return response()->json(['added',$result]);
            }

        }
        catch(Exception $ex)
        {
            return response()->json([ 'err' , __('lang.not_found')]);
        }

    }
}
