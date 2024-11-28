<?php

namespace App\Http\Controllers\Site\Exam;

use App\Models\Category;
use App\Models\Question;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;

class ExamController extends Controller
{
    private $question ,$pass ,$student_exam;

    public function __construct(PassExamRepositoryInterface $pass ,
    QuestionRepositoryInterface $question ,StudentExamRepositoryInterface $student_exam)
    {
        $this->question = $question;
        $this->pass = $pass;
        $this->student_exam = $student_exam;
    }

    public function index()
    {
        $categories = Category::category('exam')->whereHas('childs', function ($query) {
            $query->whereHas('passExam', function ($query) {
                $query->whereHas('questions');
            });
        })->where('parent_id',NULL)->with('childs')->get();
        return view('site.exams.index',compact('categories'));
    }

    public function enterExam(Request $request, $id)
    {

        try
        {
            $exam = $this->pass->getById($id);
            if(isset($exam))
            {
                $another_exams = StudentExam::where([
                    'user_id' => auth()->id(),
                    'status' => 1,
                    ['exam_id' , '!=' , $id],
                    ])->orWhere('exam_id' ,NULL)->get();

                if($another_exams->count() > 0)
                {
                    foreach($another_exams as $another_exam)
                    {
                        $another_exam->update(['status' => 0]);
                    }
                }

                $questions = Question::where('exam_id',$exam->id)->get();
                if($exam->questions_number == $questions->count()){

                    // check number of attemps for user
                    $attemps_number = StudentExam::where(['exam_id' => $exam->id,'user_id' => auth()->id()
                    ,'status' => 0])->get()->count();
                    if($attemps_number >= $exam->attemps)
                    {
                        return back()->with('failed' , __('lang.attemps_exceeded'));
                    }

                    $student_exam = StudentExam::where(['exam_id' => $exam->id,'user_id' => auth()->id()])->first();
                    if($student_exam)
                    {
                        $exam_status = StudentExam::where(['user_id' => auth()->id(),'status' => 1])->first();
                        if(!$exam_status)
                        {
                            $last_attempt = StudentExam::where(['user_id' => auth()->id()])->orderBy('id', 'desc')->first();
                            // save exam infos
                            $stu_exam = new StudentExam;
                            $stu_exam->user_id = auth()->id();
                            $stu_exam->status = 1;
                            $stu_exam->exam_id = $exam->id;
                            $stu_exam->result = 0;
                            $stu_exam->total = 0;
                            $stu_exam->attempt = $last_attempt->attempt + 1;

                            $cur_time=date("H:i:s");
                            $curent=strtotime($cur_time);
                            $duration='+'.$exam->exam_time. 'minutes';
                            $end= strtotime(date('H:i:s', strtotime($duration, strtotime($cur_time))));

                            $stu_exam->start_at = $curent;
                            $stu_exam->end_at = $end;
                            $stu_exam->save();

                            $student_exam_id = $stu_exam->id;
                            $timer = $exam->exam_time;
                            return view('site.exams.exam_page',compact('questions','exam','student_exam_id','timer'));

                        }
                        else
                        {


                            $timer = number_format((float)(($exam_status->end_at - strtotime(date("H:i"))) / 60), 2, '.', '');
                            $questions_number = $exam_status->questions_number;
                            if($timer <= 0){
                                // dd($timer);
                                $exam_status->update(['status' => 0]);
                                return redirect()->route('enter_exam',$exam->id);
                            }
                            $student_exam_id = $exam_status->id;
                            return view('site.exams.exam_page',compact('questions','exam','student_exam_id','timer'));
                        }

                    }
                    else
                    {
                        // save exam infos
                        $stu_exam = new StudentExam;
                        $stu_exam->user_id = auth()->id();
                        $stu_exam->status = 1;
                        $stu_exam->exam_id = $exam->id;
                        $stu_exam->result = 0;
                        $stu_exam->total = 0;
                        $stu_exam->attempt = 1;

                        $cur_time=date("H:i:s");
                        $curent=strtotime($cur_time);
                        $duration='+'.$exam->exam_time. 'minutes';
                        $end= strtotime(date('H:i:s', strtotime($duration, strtotime($cur_time))));

                        $stu_exam->start_at = $curent;
                        $stu_exam->end_at = $end;
                        $stu_exam->save();

                        $student_exam_id = $stu_exam->id;
                        $timer = $exam->exam_time;
                        return view('site.exams.exam_page',compact('questions','exam','student_exam_id','timer'));
                    }

                }
                else
                {
                    return back()->with('failed' , __('lang.all_questions_not_added'));
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


    public function SubmitExam(Request $request)
    {
        try
        {
            $answers = json_decode($request->true_answers[0]);
            for($i=0; $i < sizeOf($request->questions); $i++)
            {
                $question = new StudentAnswer;

                $question_type = $this->question->getById($request->questions[$i]);

                $question->question_id = $request->questions[$i];
                $question->student_answer = $answers[$i] != null ? $answers[$i] : 'not_answered';
                if($question_type->type == 'true_false' || $question_type->type == 'multi_choice')
                {
                    if($answers[$i] == $question_type->true_answer)
                    {
                        $question->teacher_degree = $question_type->degree;
                        $question->type = 1;
                    }
                    else
                    {
                        $question->teacher_degree = 0;
                        $question->type = 0;
                    }
                }
                $question->attemp_id = $request->exam_id;
                $question->save();
            }

            $student_exam = $this->student_exam->getById($request->exam_id);
            $student_exam->update(['status' => 0]);

            if($student_exam->passExam->mainLevel->type == 'contest')
            {
                return redirect()->route('attempts','contests')->with('success', __('lang.done_exam'));
            }
            else
            {
                return redirect()->route('attempts.details',$student_exam->exam_id)->with('success', __('lang.done_exam'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
