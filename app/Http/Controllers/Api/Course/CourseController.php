<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Course;
use App\Models\Content;
use App\Models\Category;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ContentResource;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\AllContentResource;
use App\Http\Resources\AttachmentResource;
use App\Http\Requests\Rating\RatingRequest;
use App\Repository\CourseRepositoryInterface;
use App\Repository\RatingRepositoryInterface;
use App\Http\Resources\CategoryCoursesResource;
use App\Repository\CategoryRepositoryInterface;
use App\Http\Resources\CoursePaginateCollection;

class CourseController extends Controller
{

    private $category,$course ,$rating;

    public function __construct(CategoryRepositoryInterface $category,CourseRepositoryInterface $course,
    RatingRepositoryInterface $rating)
    {
        $this->category = $category;
        $this->course = $course;
        $this->rating = $rating;

        $auth = request()->hasHeader('token');
         //dd(request()->header());
         if(request()->hasHeader('token'))
         {
            $this->middleware('jwt.verify')->only('index');
         }

    }


    public function index()
    {
        try
        {
            $courses = Course::query()->where('active', 1)->paginate(6);
            return new CoursePaginateCollection($courses);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function show($id)
    {
        $course = $this->course->getById($id);
        try
        {
            if($course)
            {
                $units = Content::where(['course_id'=> $course->id,'type' => 'unit'])->get();
                return response()->json(['data' => AllContentResource::collection($units),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.can_not_access'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }



    public function CategoryCourses($id)
    {
        $category = $this->category->getById($id);
        try
        {
            if(isset($category) && $category->type == 'course')
            {
                $courses = Course::where('category_id',$id)->paginate(6);
                return new CoursePaginateCollection($courses);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found_category'),'status' => 401]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
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

    public function CourseAttachment($id)
    {
        $course = $this->course->getById($id);
        try
        {
            if(isset($course) && $course->subscribedApi())
            {
                $contents = Content::where(['course_id'=>$id , 'type' => 'attachement'])->get();
                return response()->json(['data' => AttachmentResource::collection($contents),'status' => 200]);
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

    public function CourseCats($type)
    {
        try
        {
            $categories = Category::where(['type' => $type])->get();
            return response()->json(['data' => new ModelCollection(CategoryResource::collection($categories)),'status' => 200]);

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function SubscribedCourses()
    {
        $user = JWTAuth::user();
        try
        {
            $subscribes_ids = Subscribe::where(['user_id' => $user->id,'active' => 1])->get()->pluck('course_id');
            $courses = Course::whereIn('id' , $subscribes_ids)->get();
            return response()->json(['data' => CourseResource::collection($courses),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }


    public function CourseRate(RatingRequest $request , $id)
    {
        $course = $this->course->getById($id);
        try
        {
            if($course)
            {
                $data = [
                    'comment' => $request->comment,
                    'rating' => $request->rating,
                    'user_id' => JWTAuth::user()->id,
                    'course_id' => $course->id
                ];

                $rate = $this->rating->create($data);
                return response()->json(['data' => __('lang.added'), 'rate_id' => $rate->id, 'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.course_not_exist'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function UpdateCourseRate(RatingRequest $request , $id)
    {
        $rating = $this->rating->getById($id);
        try
        {
            if($rating && $rating->user_id == JWTAuth::user()->id)
            {
                $data = [
                    'comment' => $request->comment,
                    'rating' => $request->rating,
                    'user_id' => JWTAuth::user()->id,
                    'course_id' => $rating->course_id
                ];

                $this->rating->update($id,$data);
                return response()->json(['data' => __('lang.updated'),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.rating_not_exist'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }


}
