<?php

namespace App\Http\Controllers\Site\Course;

use App\Models\Course;
use App\Models\Content;
use App\Models\Progress;
use Illuminate\Http\Request;
use App\Models\ContentComment;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\CourseRepositoryInterface;
use App\Repository\ContentRepositoryInterface;
use App\Repository\SubscribeRepositoryInterface;

class SingleCourseController extends Controller
{
    private $course,$content,$subscribe;

    public function __construct(CourseRepositoryInterface $course , ContentRepositoryInterface $content
    ,SubscribeRepositoryInterface $subscribe)
    {
        $this->course = $course;
        $this->content = $content;
        $this->subscribe = $subscribe;
    }


    public function CoursePdf(Request $request,$id)
    {
        try
        {
            $content = $this->content->getById($id);
            if(isset($content))
            {
                return view('site.courses.pdf',compact('content'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }





    public function show($id)
    {
        $unit = Content::where('id',$id)->first();
        try
        {
            if(isset($unit))
            {
                $course = $this->course->getById($unit->course_id);
                if($course->subscribed())
                {
                    if($course->subscribed()->end_subscribe != null)
                    {
                        $input = $course->subscribed()->end_subscribe;
                        $date = strtotime($input);
                        if(date('Y-m-d') < date('Y-m-d', $date))
                        {
                            if(isset($course))
                            {
                                $sections = Content::where(['course_id' => $course->id,'type'=>'section' , 'parent_id' => $unit->id])->get();
                                $attachements = Content::where(['course_id' => $course->id,'type'=>'attachement'])->get();
                                return view('site.courses.single.index',compact('course','sections','attachements' , 'unit'));
                            }
                            else
                            {
                                return back()->with('failed' , __('lang.not_found'));
                            }
                        }
                        else
                        {
                            $subscribed = $this->subscribe->getById($course->subscribed()->id);
                            $subscribed->update([
                                'end_subscribe' => null,
                            ]);
                            return back()->with('failed' , __('lang.expired_subscribtion'));
                        }

                    }
                    else
                    {
                        return back()->with('failed' , __('lang.can_not_access'));
                    }
                }
                else
                {
                    return back()->with('failed' , __('lang.can_not_access'));
                }
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


    public function getContent(Request $request)
    {
        try
        {
            $content = $this->content->getById($request->id);
            if(isset($content))
            {
                $comments = ContentComment::where(['content_id' => $content->id , 'parent_id' => NULL])->orderBy('id','desc')->get();
                $result = view('site.courses.single.content',compact('content'))->render();
                $result2 = view('site.courses.single.comments',compact('comments'))->render();
                Progress::query()->updateOrCreate([
                    'content_id' => $content->id,
                    'user_id' => auth()->id(),
                ]);
                return response()->json([$result,$result2]);
            }
            else
            {
                return response()->json('err');
            }
        }
        catch(Exception $ex)
        {
            return response()->json('err');
        }
    }

    public function CourseUnits(Request $request,$id)
    {
        try
        {
            $course = $this->course->getById($id);
            if($course->subscribed())
            {
                if($course->subscribed()->end_subscribe != null)
                {
                    $input = $course->subscribed()->end_subscribe;
                    $date = strtotime($input);
                    if(date('Y-m-d') < date('Y-m-d', $date))
                    {
                        if(isset($course))
                        {
                            $units = Content::where(['course_id' => $course->id,'type'=>'unit'])->get();
                            return view('site.courses.single.units',compact('units','course'));
                        }
                        else
                        {
                            return back()->with('failed' , __('lang.not_found'));
                        }
                    }
                    else
                    {
                        $subscribed = $this->subscribe->getById($course->subscribed()->id);
                        $subscribed->update([
                            'end_subscribe' => null,
                            'active' => 0
                        ]);
                        return redirect()->route('course.show', $id)->with('failed' , __('lang.subscribe ended'));
                    }

                }
                else
                {
                    $subscribed = $this->subscribe->getById($course->subscribed()->id);
                        $subscribed->update([
                            'end_subscribe' => null,
                            'active' => 0
                        ]);
                        return redirect()->route('course.show', $id)->with('failed' , __('lang.subscribe ended'));
                }
            }
            else
            {//
//                $subscribed = $this->subscribe->getById($course->subscribed()->id);
//                        $subscribed->update([
//                            'end_subscribe' => null,
//                            'active' => 0
//                        ]);
                        return redirect()->route('course.show', $id)->with('failed' , __('lang.subscribe ended'));
            }
        }
        catch(Exception $ex)
        {
            return response()->json('err');
        }
    }

    public function CourseProgress(Request $request)
    {
        try
        {
            $content = $this->content->getById($request->content);
            if(isset($content))
            {
                $progress = Progress::where(['content_id' => $content->id, 'user_id' => auth()->id()])->first();
                if(!isset($progress))
                {
                    $new_progress = new Progress;
                    $new_progress->user_id = auth()->id();
                    $new_progress->content_id = $content->id;
                    $new_progress->save();
                }
                return response()->json('done');
            }
            else
            {
                return response()->json('err');
            }
        }
        catch(Exception $ex)
        {
            return response()->json('err');
        }
    }

}
