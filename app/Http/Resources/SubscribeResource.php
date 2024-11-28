<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscribeResource extends JsonResource
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
            'course' => $this->course->only(['title','image']),
            'active' =>  $this->active,
            'teachers' => $this->course->teachers->map(function ($teacher) {
                return [
                    'name' =>  $teacher->name,
                ];
            }),
            'created_at' =>  $this->created_at,
            'updated_at' =>  $this->updated_at,
        ];
    }
}
