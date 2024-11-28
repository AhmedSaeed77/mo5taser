<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'coupon' => $this->coupon,
            'type' => $this->type,
            'discount_percent' => $this->discount,
            'discount_number' => $this->discount_number,
            'use_number' => $this->use_number,
            'course_id' => $this->course->id,
            'course' => $this->course->title,
            'price' => $this->course->price_after ? $this->course->price_after : $this->course->price,
        ];
    }
}
