<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'image_login' => $this->image_login,
            'image_register' => $this->image_register,
            'image_join_us' => $this->image_join_us,
            'image_top_logo' => $this->image_top_logo,
            'image_footer_logo' => $this->image_footer_logo,
            'image_fav' => $this->image_fav
        ];
    }
}
