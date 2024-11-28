<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'course_group' => $this->course->course_group ?? '',
            'lessons' => $this->childs->map(function ($child) {
                return [
                    'id' =>  $child->id,
                    'title' =>  $child->title,
                    'instructions' =>  $child->instructions,
                    'desc' =>  $child->desc,
                    'attempts_count' =>  $child->attempts_count,
                    'attempts_before' =>  $child->getExamined(),
                    'type' =>  $child->type,
                    'video_platform' =>  $child->video_platform,
                    'video_url' =>  $child->video_id,
                    'questions_number' =>  $child->questions_number,
                    'exam_time' =>  $child->exam_time,
                    'live_url' =>  $child->live_url,
                    'recorded_url' =>  $child->recorded_url,
                    'zoom_time' =>  $child->zoom_time,
                    'attachement' =>  $child->attachement,
                    'download' =>  $child->download,
                    'course' =>  $child->course->title,
                    'progressable' =>  $child->progressable(),
                    'lesson-content' => $child->childs->map(function ($lesson_child) {
//                        if($lesson_child->type != 'attachement')
//                        {
                            return [
                                 'id' => $lesson_child->id,
                                 'title' => $lesson_child->title,
                                 'instructions' =>  $lesson_child->instructions,
                                 'desc' => $lesson_child->desc,
                                 'attempts_count' => $lesson_child->attempts_count,
                                 'attempts_before' => $lesson_child->getExamined(),
                                 'type' => $lesson_child->type,
                                 'content-category-count' => $lesson_child->contentCategoryCount(),
                                 'video_platform' => $lesson_child->video_platform,
                                 'video_url' => $lesson_child->video_id,
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
                                             'user_name' => $child_comment->user->name ?? 'Anonymous',
                                             'user_image' => $child_comment->user->image ?? '',
                                            ];
                                         })
                                     ];
                                 })
                            ];
//                        }
                    })
                ];
            }),
        ];
    }
}

