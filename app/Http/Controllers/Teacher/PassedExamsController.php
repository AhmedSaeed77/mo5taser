<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Subject;
use App\Models\PassExam;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\AdminRepositoryInterface;
use App\Repository\SubjectRepositoryInterface;
use App\Repository\PassExamRepositoryInterface;
use App\Mail\sendGift;

class PassedExamsController extends Controller
{
    private $pass , $admin ,$subject;

    public function __construct(PassExamRepositoryInterface $pass
    ,AdminRepositoryInterface $admin ,SubjectRepositoryInterface $subject)
    {
        $this->pass = $pass;
        $this->admin = $admin;
        $this->subject = $subject;
    }

    public function index()
    {
        $passes = PassExam::where('teacher_id' , auth()->id())->get();
        return view('teachers.passed_exams.index',compact('passes'));
    }

    public function ExamQuestions($teacher_id,$exam_id)
    {
        try
        {
            $exam = $this->pass->getById($exam_id);
            $teacher = $this->admin->getById($teacher_id);

            if(isset($exam) && isset($teacher) && auth()->id() == $teacher->id)
            {
                $questions = Question::where('exam_id',$exam->id)->get();
                return view('teachers.passed_exams.questions.index',compact('exam_id','teacher_id','questions'));
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

    public function createExam($teacher_id,$exam_id)
    {
        try
        {
            $exam = $this->pass->getById($exam_id);
            $teacher = $this->admin->getById($teacher_id);

            if(isset($exam) && isset($teacher) && auth()->id() == $teacher->id)
            {
                $notifications = Auth::user()->Notifications()->get();

                foreach($notifications as $notification) {
                    if($notification->data['id'] == $exam_id && $notification->data['teacher_id'] == $teacher_id && $notification->read_at == NULL){
                        $notification->markAsRead();
                        break;
                    }
                }
                $subjects = Subject::where('Parent_id',NULL)->get();
                $questions = Question::where('exam_id',$exam->id)->get()->count();
                return view('teachers.passed_exams.questions.create',compact('exam_id','teacher_id','exam','subjects','questions'));
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
    public function sendGift(Request $request)
    {
        try
        {
            $user = User::where('id',$request->user_id)->first();

            \Mail::to($user->email)->send(new sendGift($request->msg));
            return back()->with('success' , __('lang.sent'));
        }

        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }

    }

}
