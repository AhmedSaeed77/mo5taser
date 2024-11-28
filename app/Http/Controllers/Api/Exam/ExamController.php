<?php

namespace App\Http\Controllers\Api\Exam;

use App\Models\Category;
use App\Models\PassExam;
use App\Models\Progress;
use App\Models\Question;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;
use App\Traits\FileManagerTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\PassResource;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\AttemptResource;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\QuestionResource;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;

class ExamController extends Controller
{
    use FileManagerTrait;
    private $pass ,$student_exam,$question;

    public function __construct(PassExamRepositoryInterface $pass,StudentExamRepositoryInterface $student_exam
    ,QuestionRepositoryInterface $question)
    {
        $this->pass = $pass;
        $this->student_exam = $student_exam;
        $this->question = $question;
    }


    public function index()
    {
        try
        {
            $categories = Category::category('exam')->where('parent_id','!=',NULL)->get();
            $pass_contests = PassExam::whereIn('level',$categories->pluck('id')->toArray())->get();
            return response()->json(['data' => new ModelCollection(PassResource::collection($pass_contests)),'status' => 200]);

        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function userExams()
    {
        try
        {
            $exams = array_unique(StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 0,])
            ->where('exam_id', '!=' , NULL)->get()->pluck('exam_id')->toArray());
            $pass_contests = PassExam::whereIn('id',$exams)->get();
            return response()->json(['data' => new ModelCollection(PassResource::collection($pass_contests)),'status' => 200]);

        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }


    public function enterExam(Request $request, $id)
    {

        try
        {
            $exam = $this->pass->getById($id);
            if(isset($exam))
            {
                $questions = Question::where('exam_id',$exam->id)->get();
                if($exam->questions_number == $questions->count()){

                    // check number of attemps for user
                    $attemps_number = StudentExam::where(['exam_id' => $exam->id,'user_id' => JWTAuth::user()->id
                    ,'status' => 0])->get()->count();
                    if($attemps_number >= $exam->attemps)
                    {
                        $exam_id_attempt = StudentExam::where(['exam_id' => $exam->id,'user_id' => JWTAuth::user()->id
                        ,'status' => 0])->first();
                        return response()->json(['data' =>
                        [
                        'msg' =>  __('lang.attemps_exceeded'),
                        'exam' => $exam_id_attempt->id,
                        ]
                        ,'status' => 422]);
                    }

                    $student_exam = StudentExam::where(['exam_id' => $exam->id,'user_id' => JWTAuth::user()->id])->first();
                    if($student_exam)
                    {
                        $exam_status = StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 1])->first();
                        if(!$exam_status)
                        {
                            $last_attempt = StudentExam::where(['user_id' => JWTAuth::user()->id])->orderBy('id', 'desc')->first();
                            // save exam infos
                            $stu_exam = new StudentExam;
                            $stu_exam->user_id = JWTAuth::user()->id;
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

                            return response()->json(['data' =>
                            [
                               'questions' =>  new ModelCollection(QuestionResource::collection($questions)),
                               'exam' => $exam->id,
                               'student_exam_id' => $student_exam_id,
                               'timer' => $timer
                            ]
                            ,'status' => 200]);

                        }
                        else
                        {

                            $timer = number_format((float)(($exam_status->end_at - strtotime(date("H:i"))) / 60), 2, '.', '');
                            $questions_number = $exam_status->questions_number;
                            if($timer <= 0){
                                // dd($timer);
                                $exam_status->update(['status' => 0]);
                                return response()->json(['data' =>
                                [
                                'msg' =>  __('lang.exam_closed'),
                                'exam' => $exam_status->id,
                                ]
                                ,'status' => 422]);
                            }
                            $student_exam_id = $exam_status->id;
                            return response()->json(['data' =>
                            [
                               'questions' =>  new ModelCollection(QuestionResource::collection($questions)),
                               'exam' => $exam->id,
                               'student_exam_id' => $student_exam_id,
                               'timer' => $timer
                            ]
                            ,'status' => 200]);
                        }

                    }
                    else
                    {
                        // save exam infos
                        $stu_exam = new StudentExam;
                        $stu_exam->user_id = JWTAuth::user()->id;
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
                        return response()->json(['data' =>
                            [
                               'questions' =>  new ModelCollection(QuestionResource::collection($questions)),
                               'exam' => $exam->id,
                               'student_exam_id' => $student_exam_id,
                               'timer' => $timer
                            ]
                            ,'status' => 200]);
                    }

                }
                else
                {
                    return response()->json(['data' => __('lang.all_questions_not_added'),'status' => 422]);
                }
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 422]);
            }
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }


    public function SubmitExam(Request $request)
    {


        try
        {
            $questions = explode("||",$request->questions);
            $answers = $request->true_answers;
            for($i=0; $i < sizeOf($questions); $i++)
            {
                $question = new StudentAnswer;
                $question_type = $this->question->getById($questions[$i]);

                $question->question_id = $questions[$i];
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
            return response()->json(['data' =>
            [
                'msg' =>  __('lang.done_exam'),
                'exam' => $student_exam->id,
            ]
            ,'status' => 200]);
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }


    public function attemptResult($id)
    {
        try
        {
            $exam = $this->student_exam->getById($id);
            if(isset($exam))
            {
                if($exam->user_id == JWTAuth::user()->id)
                {
                    $answers = StudentAnswer::where(['attemp_id' => $exam->id])->get();
                    $questions = Question::where('exam_id',$exam->exam_id)->get();
                    if(($answers->count() == $questions->count()))
                    {
                        $right_answers = StudentAnswer::where(['attemp_id' => $exam->id , 'type' => '1'])->get();
                        $wrong_answers = \App\Models\StudentAnswer::where(['attemp_id' => $exam->id , 'type' => '0'])->where('student_answer', '!=', 'not_answered')->get();
                        $uncompleted_answers = \App\Models\StudentAnswer::where(['attemp_id' => $exam->id , 'student_answer' => 'not_answered'])->get();
                        $finsh_answers = $answers->pluck('type')->toArray();
                        if(!in_array(null, $finsh_answers,true))
                        {
                            if(array_sum($questions->pluck('degree')->toArray()) > 0)
                            {
                                $total = (array_sum($answers->pluck('teacher_degree')->toArray())  / array_sum($questions->pluck('degree')->toArray())) * 100;
                                $total = number_format($total, 2);
                            }
                            else
                            {
                                $total = 0;
                            }

                            return response()->json(['data' =>
                            [
                               'questions' =>  new ModelCollection(QuestionResource::collection($questions)),
                               'answers' =>  new ModelCollection(AnswerResource::collection($answers)),
                               'right_answers' => count($right_answers),
                               'wrong_answers' => $wrong_answers,
                               'uncompleted_answers' => count($uncompleted_answers),
                            ]
                            ,'status' => 200]);

                        }
                        else
                        {
                            return response()->json(['data' => __('lang.not_all_answers'),'status' => 400]);
                        }
                    }
                    else
                    {
                        return response()->json(['data' => __('lang.uncompleted_attempt'),'status' => 400]);
                    }
                }
                else
                {
                    return response()->json(['data' => __('lang.not_found_user'),'status' => 400]);
                }
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }


    public function getExamAttempts($id)
    {
        try
        {
            $pass = $this->pass->getById($id);
            if(isset($pass))
            {
                $attempts = StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 0,])
                       ->where('exam_id',$pass->id)->get();

                return response()->json(['data' => new ModelCollection(AttemptResource::collection($attempts)),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

}
