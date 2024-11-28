<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AffilateSubscribeResource extends JsonResource
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
            'course' => $this->course->title,
            'user' => $this->user->name,
            'coupon' => $this->coupon,
            'difference' => $this->difference,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
