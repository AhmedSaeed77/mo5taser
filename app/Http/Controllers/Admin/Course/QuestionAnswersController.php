<?php

namespace App\Http\Controllers\Admin\Course;

use App\Models\Course;
use App\Models\QACourse;
use App\Scopes\ActiveScope;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\NewsRequest;
use App\Repository\CourseRepositoryInterface;
use App\Http\Requests\Course\QuestionAnswerRequest;
use App\Repository\QuestionAnswerRepositoryInterface;

class QuestionAnswersController extends Controller
{
    private $question;

    public function __construct(QuestionAnswerRepositoryInterface $question)
    {
        $this->question = $question;
    }

    public function show($id)
    {
        try
        {
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $questions = QACourse::where('course_id',$course->id)->get();
                return view('dashboard.courses.questions_answers.index',compact('questions','course'));
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
            $question = $this->question->getById($id);
            if(isset($question))
            {
                $question = $this->question->getById($id);
                return view('dashboard.courses.questions_answers.edit',compact('question'));
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

    public function store(QuestionAnswerRequest $request)
    {
        try
        {
            $data = [
                'question_ar' => $request->question_ar,
                'question_en' => $request->question_en,
                'answer_ar' => $request->answer_ar,
                'answer_en' => $request->answer_en,
                'course_id' => $request->course_id,
            ];

            $this->question->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(QuestionAnswerRequest $request,$id)
    {
        try
        {
            $question = $this->question->getById($id);
            if(isset($question))
            {
                $data = [
                    'question_ar' => $request->question_ar,
                    'question_en' => $request->question_en,
                    'answer_ar' => $request->answer_ar,
                    'answer_en' => $request->answer_en,
                    'course_id' => $request->course_id,
                ];

                $this->question->update($id,$data);
                return redirect()->route('question_answer.show',$question->course_id)->with('success' , __('lang.updated'));
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
