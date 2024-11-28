<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Course;
use App\Models\Content;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Content\ContentRequest;
use App\Repository\ContentRepositoryInterface;

class CourseContentController extends Controller
{
    use FileManagerTrait;
    private $content;
    public function __construct(ContentRepositoryInterface $content)
    {
        $this->content = $content;
    }

    public function show($id)
    {
        $unit = Content::withoutGlobalScope(ActiveScope::class)->where('id',$id)->first();
        try
        {
            if(isset($unit))
            {
                $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($unit->course_id);
                if(isset($course))
                {
                    $lessons = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id'=> $unit->course_id,'type' => 'lesson'])->get();
                    $sections = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id'=> $unit->course_id,'type' => 'section'])->get();


                    // $contents = $unit->childs()->withoutGlobalScope(ActiveScope::class)
                    //     ->whereIn('id', $sections->pluck('id')->toArray() ?? [])
                    //     ->with(['childs' => function($query) use ($lessons){
                    //         $query->whereIn('id', $lessons->pluck('id')->toArray() ?? [])
                    //             ->with(['childs']);
                    //     }])->get();


                    $parents = Content::withoutGlobalScope(ActiveScope::class)
                    ->where('parent_id',$unit->id)->get()->collect();


                    $contents_lessons = Content::withoutGlobalScope(ActiveScope::class)
                    ->whereIn('parent_id',$parents->pluck('id')->toArray())->get()->collect();

                    $childs_lessons = Content::withoutGlobalScope(ActiveScope::class)
                    ->whereIn('parent_id',$contents_lessons->pluck('id')->toArray())->get()->collect();

                    $contents = $parents->merge($contents_lessons)->merge($childs_lessons);

                    $units = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id'=> $unit->course_id ,'type' => 'unit'])->get();

                    return view('teachers.courses_content.index',compact('contents','course','sections','lessons','units','unit'));
                }
                else
                {
                    return back()->with('failed' , __('lang.not_found'));
                }
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function CourseUnits($id)
    {
        $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        try
        {
            if(isset($course))
            {
                $units = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id'=> $id,'type' => 'unit'])->get();
                return view('teachers.courses_content.units',compact('course','units'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {

        $content =  Content::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        try
        {
            if(isset($content))
            {
                $content = Content::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
                $lessons = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id'=> $content->course_id,'type' => 'lesson'])->get();
                $sections = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id'=> $content->course_id,'type' => 'section','id' => $content->parent_id])->get();
                $units = Content::withoutGlobalScope(ActiveScope::class)->where(['course_id' => $content->course_id,'type' => 'unit'])->get();
                return view('teachers.courses_content.edit',compact('content','sections','units','lessons'));
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

    private function getVideoId($url)
    {
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?.*v=|embed\/|v\/))([^\s&]+)/', $url, $matches)) {
            return $matches[1]; // YouTube video ID
        } elseif (preg_match('/(?:vimeo\.com\/(?:channels\/|groups\/|album\/\d+\/video\/|video\/|ondemand\/|video\/|))(\d+)/', $url, $matches)) {
            return $matches[1]; // Vimeo video ID
        }

        return $url;
    }



    public function store(ContentRequest $request)
    {
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'desc_ar' => $request->desc_ar,
                'desc_en' => $request->desc_en,
                'instructions_ar' => $request->instructions_ar,
                'instructions_en' => $request->instructions_en,
                'type' => $request->type,
                'sort' => $request->sort,
                'active' => $request->active ?? 1,
                'attempts_count' => $request->attempts_count,
                'course_id' => $request->course_id,
                'video_platform' => $request->video_platform,
                'video_url' => $request->video_url,
                'video_id' => $this->getVideoId($request->video_url),
                'live_url' => $request->live_url,
                'recorded_url' => $request->recorded_url,
                'recorded_platform' => $request->recorded_platform,
                'recorded_id' => $this->getVideoId($request->recorded_url),
                // 'zoom_date' => $request->zoom_date,
                'zoom_time' => $request->zoom_time,
                'download' => $request->download,
                'questions_number' => $request->questions_number,
                'exam_time' => $request->exam_time,
                'parent_id' => $request->parent_id,
                'attachement' => $this->upload('attachement','courses'),
                'image' => $this->upload('image','units'),
            ];

            $this->content->create($data);
            return redirect()->back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(ContentRequest $request,$id)
    {
        $content =  Content::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        try
        {
            if(isset($content))
            {
                $content->update([
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                    'desc_ar' => $request->desc_ar,
                    'desc_en' => $request->desc_en,
                    'instructions_ar' => $request->instructions_ar,
                    'instructions_en' => $request->instructions_en,
                    'attempts_count' => $request->attempts_count,
                    'sort' => $request->sort,
                    'active' => $request->active ?? 1,
                    'type' => $request->type ? $request->type : $content->type,
                    'course_id' => $request->course_id ? $request->course_id : $content->course_id,
                    'video_platform' => $request->video_platform,
                    'video_url' => $request->video_url ? $request->video_url : $content->video_url,
                    'video_id' => $this->getVideoId($request->video_url),
                    'live_url' => $request->live_url ? $request->live_url : $content->live_url,
                    'recorded_url' => $request->recorded_url,
                    'recorded_platform' => $request->recorded_platform,
                    'recorded_id' => $this->getVideoId($request->recorded_url),
                    // 'zoom_date' => $request->zoom_date ? $request->zoom_date : $content->zoom_date,
                    'zoom_time' => $request->zoom_time ? $request->zoom_time : $content->zoom_time,
                    'download' => $request->download,
                    'questions_number' => $request->questions_number ? $request->questions_number : $content->questions_number,
                    'exam_time' => $request->exam_time ? $request->exam_time : $content->exam_time,
                    'parent_id' => $request->parent_id ? $request->parent_id : $content->parent_id,
                    'attachement' => $request->attachement ?  $this->updateFile('attachement','courses',$course->attachement) : $content->attachement,
                    'image' => $request->image ?  $this->updateFile('image','units',$content->image) : $content->image,
                ]);

                if($content->type == 'unit')
                {
                    return redirect()->route('course-units',$content->course_id)->with('success' , __('lang.updated'));
                }
                if($content->type == 'section')
                {
                    return redirect()->route('content-courses.show',$content->parent_id)->with('success' , __('lang.updated'));
                }
                else
                {
                    return redirect()->route('content-courses.show',$content->parent->parent_id)->with('success' , __('lang.updated'));
                }
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function destroy($id)
    {
        try
        {
            $content =  Content::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($content))
            {
                $this->content->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
