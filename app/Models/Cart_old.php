<?php

namespace App\Models;


class Cart
{
    public $items = [];
    public $totalPrice;
    public $totalQuantity;

    public function __Construct($cart = null)
    {
        if($cart)
        {
            $this->items = $cart->items;
            $this->totalQuantity = $cart->totalQuantity;
            $this->totalPrice = $cart->totalPrice;
        }
        else
        {
            $this->items = [];
            $this->totalQuantity = 0;
            $this->totalPrice = 0;
        }
    }


    // function add courses to cart

    public function add($course)
    {
        $items = [
            'id' => $course->id,
            'title' => $course->title,
            'peroid' => $course->peroid,
            'price' => $course->price_after ? $course->price_after : $course->price,
            'image' => $course->image,
            'quantity' => 0,
            'coupon' => null,
            'difference' => null,
        ];

        if(!array_key_exists($course->id , $this->items))
        {
            $this->items[$course->id] = $items;
            $this->totalQuantity += 1;
            $this->totalPrice += $course->price_after ? $course->price_after : $course->price;
        }
        else
        {
            $this->totalQuantity += 1;
            $this->totalPrice += $course->price_after ? $course->price_after : $course->price;
        }
    }

    // function delete course from cart

    public function remove($id )
    {
        if(array_key_exists($id , $this->items))
        {
            $this->totalQuantity -= $this->items[$id]['quantity'];
            $this->totalPrice -= $this->items[$id]['quantity'] * $this->items[$id]['price'];
            unset($this->items[$id]);
        }
    }
}
