<?php

namespace App\Http\Controllers\Admin\Course;

use App\Models\Course;
use App\Models\QACourse;
use App\Scopes\ActiveScope;
use App\Traits\FileManagerTrait;
use App\Models\CourseStudentResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StudentResultRequest;
use App\Repository\StudentResultRepositoryInterface;
use App\Repository\QuestionAnswerRepositoryInterface;

class StudentsResultsController extends Controller
{
    private $result;
    use FileManagerTrait;

    public function __construct(StudentResultRepositoryInterface $result)
    {
        $this->result = $result;
    }

    public function show($id)
    {
        try
        {
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $results = CourseStudentResult::where('course_id',$course->id)->get();
                return view('dashboard.courses.students_results.index',compact('results','course'));
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

    public function edit($id)
    {
        try
        {
            $result = $this->result->getById($id);
            if(isset($result))
            {
                $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($result->course_id);
                return view('dashboard.courses.students_results.edit',compact('result','course'));
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

    public function store(StudentResultRequest $request)
    {
        try
        {
            $data = [
                'student_name' => $request->student_name,
                'course_id' => $request->course_id,
                'image' => $this->upload('image','stuudent_results'),
            ];

            $this->result->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(StudentResultRequest $request,$id)
    {
        try
        {
            $result = $this->result->getById($id);
            if(isset($result))
            {
                $data = [
                    'student_name' => $request->student_name,
                    'course_id' => $request->course_id,
                    'image' => $request->image ?  $this->updateFile('image','stuudent_results',$result->image) : $result->image,
                ];

                $this->result->update($id,$data);
                return redirect()->route('students_results.show',$result->course_id)->with('success' , __('lang.updated'));
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
            $question = $this->question->getById($id);
            if(isset($question))
            {
                $this->question->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
