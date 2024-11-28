<?php

namespace App\Http\Controllers\Api\Contest;

use App\Models\Subject;
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
use App\Http\Resources\ModelCollection;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\studentExamResource;
use App\Http\Resources\AttemptsDetailsResource;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;

class ContestController extends Controller
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
            $categories = Category::category('contest')->where('parent_id','!=',NULL)->get();
            $pass_contests = PassExam::whereIn('level',$categories->pluck('id')->toArray())->get();
            return response()->json(['data' => PassResource::collection($pass_contests),'status' => 200]);

        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function show($id)
    {
        try
        {
            $pass = $this->pass->getById($id);
            if(isset($pass) && $pass->childLevel->type == 'contest')
            {
                return response()->json(['data' => new PassResource($pass),'status' => 200]);
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

    public function enterExam(Request $request, $id)
    {
        try
        {
            $exam = $this->pass->getById($id);
            if(isset($exam))
            {
                $another_exams = StudentExam::where(['user_id' => JWTAuth::user()->id,
                ['exam_id' , '!=' , $exam->exam_id],'status' => 1])->get();

                $another_exams = StudentExam::where([
                    'user_id' => JWTAuth::user()->id,
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
//        return $request->all();
        try
        {
            $questions = explode("||",$request->questions);
            $answers = explode("||",$request->true_answers);
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

                $question->attemp_id = $request->student_exam_id;
                $question->save();
            }

            $student_exam = $this->student_exam->getById($request->student_exam_id);
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


    public function getAttempts($slug)
    {
        try
        {
            if($slug == 'exams')
            {
                $exam_cats = Category::where('type','exam')->get()->pluck('id')->toArray();
                $attempts = StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 0,])->get();
                $exams = PassExam::whereIn('level' , $exam_cats)->whereIn('id' , $attempts->pluck('exam_id')->toArray())->orderBy('id','desc')->get();

                return response()->json(['data' => PassResource::collection($exams),'status' => 200]);
            }
            if($slug == 'contests')
            {
                $contest_cats = Category::where('type','contest')->get()->pluck('id')->toArray();
                $attempts = StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 0,])->get();
                $exams = PassExam::whereIn('level' , $contest_cats)->whereIn('id' , $attempts->pluck('exam_id')->toArray())->orderBy('id','desc')->get();

                return response()->json(['data' => PassResource::collection($exams),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.parameter_exam_contest'),'status' => 400]);
            }
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function getAttemptsDetails($id)
    {
        try
        {
            $pass_exam = $this->pass->getById($id);
            if(isset($pass_exam))
            {
                $attempts = StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 0,'exam_id' => $id])->get();
                if($attempts->count() > 0)
                {
                    return response()->json(['data' => AttemptsDetailsResource::collection($attempts) ,'status' => 200]);
                }
                else
                {
                    return response()->json(['data' => [],'status' => 200]);
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

                        $subjects_ids = $questions->pluck('subject_id')->toArray();
                        $subjects = Subject::whereIn('id',array_unique($subjects_ids))->get();
                        $count_subjects = array_count_values($subjects_ids);

                        $subjects_analysis = [];

                        foreach ($subjects as $subject)
                        {
                            $total_subject = $count_subjects[$subject->id];
                            $right_counts_questions = $right_answers->pluck('question_id')->toArray();
                            $right_count_subjects = Question::whereIn('id',$right_counts_questions)->where('subject_id',$subject->id)->get()->count();
                            $percent = round($right_count_subjects / $total_subject * 100);
                            $rate = '';

                            if($percent > 0 && $percent <= 65)
                                $rate = __('lang.accepted');
                            elseif($percent > 65 && $percent <= 75)
                                $rate = __('lang.good');
                            elseif($percent > 75 && $percent <= 90)
                                $rate = __('lang.very_good');
                            elseif($percent > 90 && $percent <= 100)
                                $rate = __('lang.excellent');
                            else
                                $rate = __('lang.bad');

                            array_push($subjects_analysis , [$subject->name , $percent . ' %' , $rate ]);

                        }

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
                               'toatl' => $total . ' %',
                               'right_answers' => count($right_answers),
                               'wrong_answers' => count($wrong_answers),
                               'uncompleted_answers' => count($uncompleted_answers),
                               'subjects_analysis' => $subjects_analysis,
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


}
