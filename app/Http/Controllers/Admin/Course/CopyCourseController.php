<?php

namespace App\Http\Controllers\Admin\Course;

use App\Models\User;
use App\Models\Course;
use App\Models\Content;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\CourseRepositoryInterface;
use App\Repository\ContentRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\ContentCategoryRepositoryInterface;

class CopyCourseController extends Controller
{

    private $course ,$content,$question;

    public function __construct(CourseRepositoryInterface $course ,ContentRepositoryInterface $content,
    QuestionRepositoryInterface $question , ContentCategoryRepositoryInterface $content_category)
    {
        $this->course = $course;
        $this->content = $content;
        $this->question = $question;
        $this->content_category = $content_category;
    }

    function addContent($unit,$course,$parent_id = NULL)
    {
        $attach_path = NULL;
        $image_path = NULL;
        if($unit->attachement)
        {
            $paths = explode("/", $unit->attachement);
            if(file_exists($paths[2])){
                \File::copy(storage_path('app/public/courses/'.$paths[2]), storage_path('app/public/courses/'.'copy_'.$paths[2]));
                $attach_path = 'storage/courses/'.$paths[2];
            }
        }
        if($unit->image)
        {
            $paths2 = explode("/", $unit->image);
            if(file_exists($paths2[2])){
                \File::copy(storage_path('app/public/courses/'.$paths2[2]), storage_path('app/public/courses/'.'copy_'.$paths2[2]));
                $image_path = 'storage/courses/'.$paths2[2];
            }
        }

        $data = [
            'title_ar' => $unit->title_ar,
            'title_en' => $unit->title_en,
            'desc_ar' => $unit->desc_ar,
            'desc_en' => $unit->desc_en,
            'instructions_ar' => $unit->instructions_ar,
            'instructions_en' => $unit->instructions_en,
            'type' => $unit->type,
            'sort' => $unit->sort,
            'active' => $unit->active,
            'attempts_count' => $unit->attempts_count,
            'course_id' => $course->id,
            'video_url' => $unit->video_url,
            'live_url' => $unit->live_url,
            'recorded_url' => $unit->recorded_url,
            'zoom_time' => $unit->zoom_time,
            'download' => $unit->download,
            'questions_number' => $unit->questions_number,
            'exam_time' => $unit->exam_time,
            'parent_id' => $parent_id,
            'attachement' => $attach_path,
            'image' => $image_path,
        ];

        $unit_val = $this->content->create($data);

        if($unit->type == 'exam' || $unit->type == 'homework')
        {

            if($unit->questions->count() > 0)
            {
                foreach($unit->questions as $key => $item)
                {
                    $image_path_question = NULL;
                    $hint_image_path_question = NULL;
                    if($item->image)
                    {
                        $paths2 = explode("/", $item->image);
                        if(file_exists($paths2[2])){
                            \File::copy(storage_path('app/public/questions/'.$paths2[2]), storage_path('app/public/questions/'.'copy_'.$paths2[2]));
                            $image_path_question = 'storage/questions/'.$paths2[2];
                        }
                    }
                    if($item->hint_image)
                    {
                        $paths3 = explode("/", $item->hint_image);
                        if(file_exists($paths3[2])){
                            \File::copy(storage_path('app/public/questions/'.$paths3[2]), storage_path('app/public/questions/'.'copy_'.$paths3[2]));
                            $hint_image_path_question = 'storage/questions/'.$paths3[2];
                        }
                    }


                    $data_questions = [
                        'question' => $item->question,
                        'question_details' => $item->question_details,
                        'answer1' => $item->answer1,
                        'answer2' => $item->answer2,
                        'answer3' => $item->answer3,
                        'answer4' => $item->answer4,
                        'true_answer' => $item->true_answer,
                        'subject_id' => $item->subject_id,
                        'content_id' => $unit_val->id,
                        'degree' => $item->degree,
                        'video_url' => $item->video_url,
                        'type' => $item->type,
                        'hint' => $item->hint,
                        'image' => $image_path_question,
                        'hint_image' => $hint_image_path_question

                    ];

                    $this->question->create($data_questions);
                }
            }
        }

        if($unit->type == 'split_test')
        {
            if($unit->categories->count() > 0)
            {
                foreach($unit->categories as $key => $content_cat)
                {
                    $data = [
                        'name_ar' => $content_cat->name_ar,
                        'name_en' => $content_cat->name_en,
                        'questions_number' => $content_cat->questions_number,
                        'content_id' => $unit_val->id,
                        'exam_time' => $content_cat->exam_time,
                    ];

                    $content_category_val = $this->content_category->create($data);
                    if($content_cat->questions->count() > 0)
                    {
                        foreach($content_cat->questions as $key => $item)
                        {
                            $image_path_question = NULL;
                            $hint_image_path_question = NULL;
                            if($item->image)
                            {
                                $paths2 = explode("/", $item->image);
                                if(file_exists($paths2[2])){
                                    \File::copy(storage_path('app/public/questions/'.$paths2[2]), storage_path('app/public/questions/'.'copy_'.$paths2[2]));
                                    $image_path_question = 'storage/questions/'.$paths2[2];
                                }
                            }
                            if($item->hint_image)
                            {
                                $paths3 = explode("/", $item->hint_image);
                                if(file_exists($paths3[2])){
                                    \File::copy(storage_path('app/public/questions/'.$paths3[2]), storage_path('app/public/questions/'.'copy_'.$paths3[2]));
                                    $hint_image_path_question = 'storage/questions/'.$paths3[2];
                                }
                            }


                            $data_questions = [
                                'question' => $item->question,
                                'question_details' => $item->question_details,
                                'answer1' => $item->answer1,
                                'answer2' => $item->answer2,
                                'answer3' => $item->answer3,
                                'answer4' => $item->answer4,
                                'true_answer' => $item->true_answer,
                                'subject_id' => $item->subject_id,
                                'content_category_id' => $content_category_val->id,
                                'degree' => $item->degree,
                                'video_url' => $item->video_url,
                                'type' => $item->type,
                                'hint' => $item->hint,
                                'image' => $image_path_question,
                                'hint_image' => $hint_image_path_question

                            ];

                            $this->question->create($data_questions);
                        }
                    }
                }
            }

        }

        return $unit_val;
    }

    public function copyCourse(Request $request,$id)
    {
        try
        {
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $units = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id'=> $request->course_select,'type' => 'unit'])->get();

                if($units->count() > 0)
                {
                    foreach($units as $unit)
                    {
                        $unit_val = $this->addContent($unit,$course);
                        $contents = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id' => $request->course_select,'parent_id' => $unit->id])->get();
                        if($contents->count() > 0)
                        {
                            foreach($contents as $content)
                            {
                                $section_val = $this->addContent($content,$course,$unit_val->id);
                                $section_contents = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id' => $request->course_select,'parent_id' => $content->id])->get();;
                                if($section_contents->count() > 0)
                                {
                                    foreach($section_contents as $item)
                                    {
                                        $lesson_val = $this->addContent($item,$course,$section_val->id);
                                        $lesson_contents = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id' => $request->course_select,'parent_id' => $item->id])->get();;
                                        if($lesson_contents->count() > 0)
                                        {
                                            foreach($lesson_contents as $lesson)
                                            {
                                                $lesson_val = $this->addContent($lesson,$course,$section_val->id);
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                    return back()->with('success' , __('lang.added'));
                }
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(Exception $ex)
        {
            dd($ex);
            return back()->with('failed' , __('lang.not_found'));
        }



    }
}
