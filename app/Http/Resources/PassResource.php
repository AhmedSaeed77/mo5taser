<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PassResource extends JsonResource
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
            'questions_number' => $this->questions_number,
            'exam_time' => $this->exam_time,
            'attemps' => $this->attemps,
            'teacher_id' => $this->teacher->name,
            'main_cat' => $this->mainLevel->title,
            'level' => $this->childLevel->title,
            'rest' => $this->restAttempts(),
            'examined' => $this->attemps - $this->restAttempts(),
            'type' => $this->levelCat->type,
            'image' => $this->levelCat->image
        ];
    }
}

