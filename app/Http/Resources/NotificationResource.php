<?php

namespace App\Http\Resources;

use App\Models\Course;
use App\Scopes\ActiveScope;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $course  = Course::withoutGlobalScope(ActiveScope::class)->find($this->data['course_id']);
        if(!$course)
        {
            $this->delete();
        }
        else
        {
            return [
                'id' => $this->id,
                'type' => $this->data['type'],
                'read_at' => $this->read_at,
                'course' => $course->title,
                'created_at' => $this->created_at,
            ];
        }

    }
}

