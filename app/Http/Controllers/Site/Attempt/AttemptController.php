<?php

namespace App\Http\Controllers\Site\Attempt;

use App\Models\Category;
use App\Models\PassExam;
use App\Models\StudentExam;
use App\Models\StudentAnswer;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;
use App\Repository\StudentAnswerRepositoryInterface;

class AttemptController extends Controller
{

    private $pass,$answer,$exam;

    public function __construct(PassExamRepositoryInterface $pass,
    StudentAnswerRepositoryInterface $answer,StudentExamRepositoryInterface $exam)
    {
        $this->pass = $pass;
        $this->answer = $answer;
        $this->exam = $exam;
    }

    public function index($slug)
    {
        $exam_cats = Category::where('type','exam')->get()->pluck('id')->toArray();
        $contest_cats = Category::where('type','contest')->get()->pluck('id')->toArray();
        try
        {
            if($slug == 'exams')
            {
                $title = __('lang.exams');
                $exams = PassExam::whereIn('level',$exam_cats)->get();
                return view('site.users.exams_attempts',compact('exams','title'));
            }
            if($slug == 'contests')
            {
                $title = __('lang.contests');
                $exams = PassExam::whereIn('level',$contest_cats)->orderBy('id','desc')->get();
                return view('site.users.exams_attempts',compact('exams','title'));
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

    public function show($id)
    {
        try
        {
            $pass = $this->pass->getById($id);
            if(isset($pass))
            {
                $attempts = StudentExam::where(['user_id' => auth()->id(),'status' => 0,])
                       ->where('exam_id',$pass->id)->orderBy('id','desc')->get();

                return view('site.users.attempts_details',compact('attempts'));
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


    public function attemptResult($id)
    {
        try
        {
            $exam = $this->exam->getById($id);
            if(isset($exam))
            {
                if($exam->user_id == auth()->id())
                {
                    $answers = StudentAnswer::where(['attemp_id' => $exam->id])->get();
                    return view('site.users.attempt_result',compact('answers','exam'));
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
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
