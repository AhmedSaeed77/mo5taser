<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Course;
use App\Models\Content;
use App\Models\Category;
use App\Models\Progress;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ContentResource;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\AttachmentResource;
use App\Repository\CourseRepositoryInterface;
use App\Repository\ContentRepositoryInterface;
use App\Http\Resources\CategoryCoursesResource;
use App\Repository\CategoryRepositoryInterface;

class SingleCourseController extends Controller
{
    private $course ,$content;

    public function __construct(CourseRepositoryInterface $course ,ContentRepositoryInterface $content)
    {
        $this->course = $course;
        $this->content = $content;
    }

    public function CourseContent($id)
    {
        $course = $this->course->getById($id);
        try
        {
            if(isset($course))
            {
                $contents = Content::where(['course_id'=>$id , 'type' => 'section'])->get();
                return response()->json(['data' => new ModelCollection(ContentResource::collection($contents)),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found_course'),'status' => 401]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function addToProgress($id)
    {
        $content = $this->content->getById($id);
        try
        {
            if(isset($content))
            {
                $progress = Progress::where(['content_id' => $content->id, 'user_id' => auth()->id()])->first();
                if(!isset($progress))
                {
                    $user = JWTAuth::user();

                    $new_progress = new Progress;
                    $new_progress->user_id = $user->id;
                    $new_progress->content_id = $content->id;
                    $new_progress->save();
                    return response()->json(['data' => 'added','status' => 200]);
                }
                else
                {
                    return response()->json(['data' => 'exist','status' => 200]);
                }
            }
            else
            {
                return response()->json(['data' => __('lang.not_found_content'),'status' => 401]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
