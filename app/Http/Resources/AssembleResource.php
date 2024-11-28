<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssembleResource extends JsonResource
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
            'assemblies' => $this->assemblies->map(function ($assemble) {
                return [
                    'id' =>  $assemble->id,
                    'title' =>  $assemble->title,
                    'content' =>  $assemble->content,
                    'type' =>  $assemble->type,
                    'book' => $assemble->book !== null ? url($assemble->book) : null,
                    'image' =>  url($assemble->image),
                    'link' =>  $assemble->link,
                    'video_platform' => $assemble->video_platform,
                    'video_id' => $assemble->video_id,
                ];
            }),
        ];
    }
}

