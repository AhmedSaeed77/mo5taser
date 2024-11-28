<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'student_answer' => $this->student_answer,
            'question_id ' => $this->question_id ,
            'teacher_degree' => $this->teacher_degree,
            'type' => $this->type
        ];
    }
}

