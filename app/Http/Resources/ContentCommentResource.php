<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentCommentResource extends JsonResource
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
            'comment' => $this->comment,
            'user_name' => $this->user->name,
            'user_image' => $this->user->image,
            'replies' => $this->childs->map(function ($child_comment) {
               return [
                'id' => $child_comment->id,
                'comment' => $child_comment->comment,
                'user_name' => $child_comment->user->name,
                'user_image' => $child_comment->user->image,
               ];
            })
        ];
    }
}

