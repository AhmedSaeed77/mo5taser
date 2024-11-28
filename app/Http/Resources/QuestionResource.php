<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question' => $this->question,
            'question_details' => $this->question_details,
            'degree' => $this->degree,
            'answer1' => $this->answer1,
            'answer2' => $this->answer2,
            'answer3' => $this->answer3,
            'answer4' => $this->answer4,
            'true_answer' => $this->true_answer,
            'image' => $this->image,
            'video_url' => $this->video_url,
            'video_platform' => $this->video_platform,
            'video_id' => $this->video_id,
            'hint' => $this->hint,
            'hint_image' => $this->hint_image,
            'hint_video' => $this->hint_video,
            'hint_video_platform' => $this->hint_video_platform,
            'hint_video_id' => $this->hint_video_id,
            'type' => $this->type,
            'subject' => $this->subjectName()
        ];
    }
}

