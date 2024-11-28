<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class studentExamResource extends JsonResource
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
            'level' => $this->passExam->childLevel->title,
            'main_cat' => $this->passExam->mainCat->title,
            // 'rest' => $this->restAttempts(),
        ];
    }
}

