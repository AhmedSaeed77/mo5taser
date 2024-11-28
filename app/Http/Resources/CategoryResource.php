<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'type' => $this->type,
            'parent' => $this->parent,
            'childs' => $this->childs->map(function ($child) {
                return [
                    'id' =>  $child->id,
                    'title' =>  $child->title,
                    'type' =>  $child->type,
                    'image' => $child->image,
                    'parent' => $child->parent,
                    'exams' => $child->exams,
                ];
            }),
        ];
    }
}
