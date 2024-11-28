<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Course;
use App\Models\Content;
use App\Models\Category;
use App\Models\Subscribe;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ContentResource;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\AttachmentResource;
use App\Http\Requests\Rating\RatingRequest;
use App\Repository\CourseRepositoryInterface;
use App\Repository\RatingRepositoryInterface;
use App\Repository\ContentRepositoryInterface;
use App\Http\Resources\CategoryCoursesResource;
use App\Repository\CategoryRepositoryInterface;

class CourseContentController extends Controller
{

    private $content,$course;
    public function __construct(ContentRepositoryInterface $content,CourseRepositoryInterface $course)
    {
        $this->content = $content;
        $this->course = $course;
        $auth = request()->hasHeader('Authorization');
        if($auth)
        {
            $this->middleware('jwt.verify');
        }
    }

    public function CourseUnits($id)
    {
        $course = $this->course->getById($id);
        try
        {
            if(isset($course))
            {
                if($course->subscribedApi())
                {
                    $units = Content::where(['course_id'=> $id,'type' => 'unit'])->get();
                    return response()->json(['data' => UnitResource::collection($units),'status' => 200]);
                }
                else
                {
                    return response()->json(['data' => __('lang.you_are_not_subscribed'),'status' => 400]);

                }
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function unitContent($id)
    {
        $unit = $this->content->getById($id);
        try
        {
            if(isset($unit))
            {
                $course = $this->course->getById($unit->course_id);
                if(isset($course) && $course->subscribedApi())
                {
                    $sections = Content::where(['course_id'=> $unit->course_id,'type' => 'section','parent_id'=> $unit->id])->get();
                    return response()->json(['data' => ContentResource::collection($sections),'status' => 200]);
                }
                else
                {
                    return response()->json(['data' => __('lang.you_are_not_subscribed'),'status' => 400]);
                }
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

}
