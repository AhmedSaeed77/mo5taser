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
            $course = Course::where('id',$request->id)->first();
            $subscribe = Subscribe::where(['course_id' =>$course->id, 'user_id' => auth()->id(), 'active' => 0])->first();
            if($subscribe)
            {
                return response()->json(['subscribtion_exist' , __('lang.course_wait_activation')]);
            }
            if(session()->has('cart'))
            {
                $cart = new Cart(session()->get('cart'));
                foreach ($cart->items as $key => $item) {
                    if($item['id'] == $course->id)
                    {
                        return response()->json([ 'exist' , __('lang.course_cart_exist')]);
                    }
                }
            }
            else
            {
                $cart = new Cart();
            }

            $cart->add($course);
            session()->put('cart' , $cart);
            $result = view('site.cart.content_header')->render();
            return response()->json(['added',$result]);
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
        try
        {
            $course = Course::where('id',$id)->first();
            $cart = new Cart(session()->get('cart'));
            foreach ($cart->items as $key => $item) {
                if($item['id'] == $course->id)
                {
                    $cart->totalPrice -= $item['price'];
                    break;
                }
            }
            $cart->totalQuantity -= 1;
            $cart->remove($course->id);

            if($cart->totalQuantity <= 0)
            {
                session()->forget('cart');
            }
            else{
                session()->put('cart' , $cart);
            }

            return back()->with('success' , __('lang.removed_from_cart'));
            // $result = view('site.cart.content_header')->render();
            // return response()->json(['removed',$result]);
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
            // return response()->json([ 'err' , __('lang.not_found')]);
        }
    }

    // updateCartValue

    public function updateCartValue(Request $request , Product $product)
    {

        $id = $request->id;
        $val = $request->val;

        if(session()->has('cart'))
        {
            $cart = new Cart(session()->get('cart'));
            foreach ($cart->items as $key => $item) {
                if($item['id'] == $id)
                {
                  $product_count = \App\Models\Product::where('id' ,$id )->first();
                  $quantity = $product_count->quantity;
                  if($val > $quantity)
                  {
                      return response()->json('failed');
                  }
                  else{
                       $cart->items[$id]['quantity'] = intval($val);
                       break;
                  }

                }
              }

              $totalQuantity = 0; $totalPrice = 0; $totalEarnedMoney=0;
              foreach ($cart->items as $key => $item) {
                $totalQuantity += $item['quantity'];
                $totalPrice += $item['quantity'] * $item['price'];
                $totalEarnedMoney += $item['quantity'] * $item['earned_money'];
              }
            $cart->totalQuantity = $totalQuantity;
            $cart->totalPrice = $totalPrice;
            $cart->totalEarnedMoney = $totalEarnedMoney;
            session()->put('cart' , $cart);
            $result = view('site.products.cart_content')->render();
            return response()->json($result);

        }



    }

    public function deleteCart()
    {
        try
        {
            $cart = new Cart(session()->get('cart'));
             foreach ($cart->items as $key => $item) {
               $cart->remove($item['id']);
             }

              session()->forget('cart');

            return redirect()->back()->with('success' , __('lang.cart_deleted'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
