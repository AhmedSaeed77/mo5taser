<?php

namespace App\Http\Resources;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Resources\Json\JsonResource;

class ExchangesResource extends JsonResource
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
            'user' => $this->user->name,
            'phone' => $this->user->phone,
            'image_transfer' => $this->image_transfer,
            'amount' => $this->amount,
            'balance' => $this->user->balance,
            'status' => __('lang.'.$this->status),
            'paid' => $this->paid == 1 ? __('lang.paid') : __('lang.unpaid'),
            'created_at' => $this->created_at->format('Y-m-d'),
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
