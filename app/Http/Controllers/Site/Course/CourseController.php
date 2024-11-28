<?php

namespace App\Http\Controllers\Site\Course;

use App\Models\Course;
use App\Models\Rating;
use App\Models\Content;
use App\Models\Subscribe;
use App\Traits\FileManagerTrait;
use App\Models\CourseStudentResult;
use App\Http\Controllers\Controller;
use App\Repository\CourseRepositoryInterface;
use Carbon\Carbon;

class CourseController extends Controller
{
    private $course;

    public function __construct(CourseRepositoryInterface $course)
    {
        $this->course = $course;
    }

    public function index()
    {
        try
        {
            return view('site.courses.index');
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function subscribeFreeCourse($id)
    {
        $course = Course::query()
            ->where('type', 'free')
            ->whereDoesntHave('subscribes', function ($query) {
                $query->where('subscribes.user_id', auth()->id())->where('active', true);
            })
            ->findOrFail($id);
        Subscribe::query()->create([
            'course_id' => $course->id,
            'user_id' => auth()->id(),
            'type' => 'free',
            'total' => 0,
            'start_subscribe' => Carbon::today()->format('Y-m-d'),
            'end_subscribe' => Carbon::now()->addDays((int)$course->peroid)->format('Y-m-d'),
            'active' => true,
        ]);
        return redirect()->route('site.course-units', $id)->with('success', __('lang.you have subscribed successfully'));
    }

    public function show($id)
    {
        try
        {
            $course = $this->course->getById($id);
            if(isset($course))
            {
                $related_courses = Course::where(['category_id' => $course->category_id,['id','!=',$id]])->get();
                //$sections = Content::where(['course_id' => $course->id,'type'=>'section'])->get();
                $units = Content::where(['course_id' => $course->id,'type'=>'unit'])->get();
                $results = CourseStudentResult::where('course_id',$course->id)->get();
                $ratings = Rating::where('course_id',$course->id)->get();
                return view('site.courses.show',compact('course','related_courses','units','results','ratings'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function showContent($id)
    {
        try
        {
            $course = $this->course->getById($id);
            if(isset($course))
            {
                return view('site.contents.iframe',compact('course'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
    public function showTable($id)
    {
        try
        {
            $course = $this->course->getById($id);
            if(isset($course))
            {
                return view('site.contents.table',compact('course'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
