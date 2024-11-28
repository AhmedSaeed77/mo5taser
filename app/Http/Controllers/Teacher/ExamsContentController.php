<?php

namespace App\Http\Controllers\Teacher;

use App\Models\StudentExam;
use App\Models\User;
use App\Notifications\activeSubscribtion;
use App\Notifications\StudentTestCorrection;
use Exception;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\ContentRepositoryInterface;
use App\Repository\SubjectRepositoryInterface;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;
use App\Repository\StudentAnswerRepositoryInterface;

class ExamsContentController extends Controller
{
    use FileManagerTrait;
    private $exam,$pass,$answer,$subject,$content;

    public function __construct(StudentExamRepositoryInterface $exam,
    PassExamRepositoryInterface $pass ,StudentAnswerRepositoryInterface $answer,
    SubjectRepositoryInterface $subject , ContentRepositoryInterface $content)
    {
        $this->exam = $exam;
        $this->pass = $pass;
        $this->answer = $answer;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function show($id)
    {
        try
        {
            $exam = $this->pass->getById($id);
            if(isset($exam))
            {
                $attempts = StudentExam::where('exam_id',$exam->id)->orderBy('id','desc')->get();
                return view('teachers.courses_content.student_results.index',compact('attempts'));
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
                $answers = StudentAnswer::where('attemp_id',$exam->id)->get();
                return view('teachers.courses_content.student_results.student_answers',compact('answers','exam'));
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
                return view('teachers.courses_content.student_results.answer',compact('answer','subjects'));
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
                return redirect()->route('content_answers',$answer->attemp_id)->with('success',__('lang.answer_sent'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(\Exception $ex)
        {
            dd($ex);
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

    public function notifyStudent($id) {
        try {
            $exam = $this->exam->getById($id);
            \Notification::send(User::where(['id' => $exam->user_id])->first(), new StudentTestCorrection($exam));
            return redirect()->back()->with('success',__('lang.notification sent'));
        } catch (Exception $exception) {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
