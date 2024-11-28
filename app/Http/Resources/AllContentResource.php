<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllContentResource extends JsonResource
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
            'type' => $this->type,
            'image' => $this->image,
            'sections' => $this->childs->map(function ($section) {
                return [
                    'id' =>  $section->id,
                    'title' =>  $section->title,
                    'instructions' =>  $section->instructions,
                    'desc' =>  $section->desc,
                    'attempts_count' =>  $section->attempts_count,
                    'attempts_before' =>  $section->getExamined(),
                    'type' =>  $section->type,
                    'video_url' =>  $section->video_url,
                    'questions_number' =>  $section->questions_number,
                    'exam_time' =>  $section->exam_time,
                    'live_url' =>  $section->live_url,
                    'recorded_url' =>  $section->recorded_url,
                    'zoom_time' =>  $section->zoom_time,
                    'attachement' =>  $section->attachement,
                    'download' =>  $section->download,
                    'course' =>  $section->course->title,
                    'progressable' =>  $section->progressable(),
                    'lessons' => $section->childs->map(function ($lesson) {
                        return [
                            'id' =>  $lesson->id,
                            'title' =>  $lesson->title,
                            'instructions' =>  $lesson->instructions,
                            'desc' =>  $lesson->desc,
                            'attempts_count' =>  $lesson->attempts_count,
                            'attempts_before' =>  $lesson->getExamined(),
                            'type' =>  $lesson->type,
                            'video_url' =>  $lesson->video_url,
                            'questions_number' =>  $lesson->questions_number,
                            'exam_time' =>  $lesson->exam_time,
                            'live_url' =>  $lesson->live_url,
                            'recorded_url' =>  $lesson->recorded_url,
                            'zoom_time' =>  $lesson->zoom_time,
                            'attachement' =>  $lesson->attachement,
                            'download' =>  $lesson->download,
                            'course' =>  $lesson->course->title,
                            'progressable' =>  $lesson->progressable(),
                            'lesson-content' => $lesson->childs->map(function ($lesson_child) {
                                   return [
                                        'id' => $lesson_child->id,
                                        'title' => $lesson_child->title,
                                        'instructions' =>  $lesson_child->instructions,
                                        'desc' => $lesson_child->desc,
                                        'attempts_count' => $lesson_child->attempts_count,
                                        'attempts_before' => $lesson_child->getExamined(),
                                        'type' => $lesson_child->type,
                                        'video_url' => $lesson_child->video_url,
                                        'questions_number' => $lesson_child->questions_number,
                                        'exam_time' => $lesson_child->exam_time,
                                        'live_url' => $lesson_child->live_url,
                                        'recorded_url' => $lesson_child->recorded_url,
                                        'zoom_time' => $lesson_child->zoom_time,
                                        'attachement' => $lesson_child->attachement,
                                        'download' => $lesson_child->download,
                                        'course' => $lesson_child->course->title,
                                        'progressable' => $lesson_child->progressable(),
                                        'comments' => $lesson_child->comments->map(function ($comment) {
                                            return [
                                                'id' => $comment->id,
                                                'comment' => $comment->comment,
                                                'user_name' => $comment->user->name,
                                                'user_image' => $comment->user->image,
                                                'replies' => $comment->childs->map(function ($child_comment) {
                                                   return [
                                                    'id' => $child_comment->id,
                                                    'comment' => $child_comment->comment,
                                                    'user_name' => $child_comment->user !== null ? $child_comment->user->name : '',
                                                    'user_image' => $child_comment->user !== null ? $child_comment->user->image : '',
                                                   ];
                                                })
                                            ];
                                        })
                                   ];
                            })
                        ];
                    }),
                ];
            }),
        ];
    }
}

