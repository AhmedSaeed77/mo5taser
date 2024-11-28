<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'course_id' => $this->course->id,
            'title' => $this->course->title,
            'image' => $this->course->image,
            'peroid' => $this->course->peroid,
            'price' => $this->price,
            'coupon' => $this->coupon,
            'difference' => $this->difference,
        ];
    }
}
