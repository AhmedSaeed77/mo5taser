<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PillResource extends JsonResource
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
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'phone' => $this->phone ?? '',
            'area' => $this->area ?? '',
            'city' => $this->city ?? '',
            'street' => $this->street ?? '',
            'product_name' => $this->assemble->title ?? '',
            'price' => $this->price ?? '',
        ];
    }
}

