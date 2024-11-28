<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleAssembleResource extends JsonResource
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
            'id' =>  $this->id,
            'title' =>  $this->title,
            'content' =>  $this->content,
            'type' =>  $this->type,
            'image' =>  $this->image,
            'book_preview' =>  $this->book_preview,
            'book' =>  $this->book,
            'link' =>  $this->link,
            'price' =>  $this->price,
        ];
    }
}

