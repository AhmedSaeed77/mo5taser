<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $subscription = auth()->check() ? auth()->user()->subscribes()->where('course_id', $this->id)->first() : null;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'desc' => $this->desc,
            'price' => $this->price,
            'price_after' => $this->price_after,
            'type' => $this->type,
            'image' => $this->image,
            'preview_video' => $this->preview_video_id,
            'preview_video_platform' => $this->preview_video_platform,
            'course_table' => $this->course_table,
            'course_bag' => $this->subscribedApi() !== null ? $this->subscribed_bag : $this->course_bag,
            'peroid' => $this->peroid,
            'start_date' => date('Y-m-d') < $this->start_date ? $this->start_date : NULL,
            'averageRate' => $this->averageRate(),
            'ratingCount' => $this->ratingCount(),
            'subscribers' => $this->subscribers > 0 ? $this->subscribers : $this->subscribers(),
            'subscribed' => $this->subscribedApi(),
            'remaining_period' => $subscription !== null && !(Carbon::parse($subscription->end_subscribe)->isPast() || Carbon::parse($subscription->end_subscribe)->isToday())
                ? Carbon::parse($subscription->end_subscribe)->diffInDays(Carbon::today()->format('Y-m-d'))
                : null,
            'progress' => $this->apiProgress(),
            'rated' => $this->rated(),
            'category' => $this->category->title,
            'teachers' => $this->teachers->pluck('name')->toArray(),
            'comments' => $this->comments->map(function ($comment) {
                return [
                    'id' =>  $comment->id,
                    'comment' =>  $comment->comment,
                    'rating' =>  $comment->rating,
                    'user' =>  $comment->user->name,
                    'me' =>  $this->myRate(),
                    'course' =>  $comment->course->title,
                ];
            }),
            'questions' => $this->questions->map(function ($question) {
                return [
                    'question' =>  $question->question,
                    'answer' =>  $question->answer
                ];
            }),
            'results' => $this->results->map(function ($result) {
                return [
                    'student_name' =>  $result->student_name,
                    'image' =>  $result->image
                ];
            }),
            'is_open' => $this->open,
            'group' => $this->course_group
        ];
    }
}

