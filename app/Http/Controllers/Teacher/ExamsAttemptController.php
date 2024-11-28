<?php

namespace App\Http\Controllers\Teacher;

use App\Models\StudentExam;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\SubjectRepositoryInterface;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;
use App\Repository\StudentAnswerRepositoryInterface;

class ExamsAttemptController extends Controller
{
    use FileManagerTrait;
    private $exam,$pass,$answer,$subject;

    public function __construct(StudentExamRepositoryInterface $exam,
    PassExamRepositoryInterface $pass ,StudentAnswerRepositoryInterface $answer, SubjectRepositoryInterface $subject)
    {
        $this->exam = $exam;
        $this->pass = $pass;
        $this->answer = $answer;
        $this->subject = $subject;
    }

    public function show($id)
    {

        try
        {
            $exam = $this->pass->getById($id);
            if(isset($exam))
            {
                $attempts = StudentExam::where('exam_id',$exam->id)->orderBy('id','desc')->get();
                return view('teachers.passed_exams.student_results.index',compact('attempts','exam'));
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

    // all student answers
    public function studentAnswers($id)
    {
        try
        {
            $exam = $this->exam->getById($id);
            if(isset($exam))
            {
                if($exam->passExam->teacher_id == auth()->id() && $exam->passExam->id == $exam->exam_id)
                {
                    $answers = StudentAnswer::where('attemp_id',$exam->id)->get();
                    return view('teachers.passed_exams.student_results.student_answers',compact('answers','exam'));
                }
                else
                {
                    return back()->with('failed' , __('lang.un_authorized'));
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

    // single student answer
    public function studentAnswer($id)
    {
        try
        {
            $answer = $this->answer->getById($id);
            if(isset($answer))
            {
                $subjects = $this->subject->getAll();
                return view('teachers.passed_exams.student_results.answer',compact('answer','subjects'));
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
    // single student answer update
    public function AnswerUpdate(Request $request , $id)
    {
        try
        {
            $answer = $this->answer->getById($id);
            if(isset($answer))
            {
                $data = [
                    'type' => $request->type,
                    'teacher_degree' => $request->teacher_degree,
                ];

                $this->answer->update($id,$data);
                return redirect()->route('students_answers',$answer->attemp_id)->with('success',__('lang.answer_sent'));
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
            $exam = $this->exam->getById($id);
            if(isset($exam))
            {
                $exam->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
