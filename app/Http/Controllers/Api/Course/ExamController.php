<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Course;
use App\Models\Content;
use App\Models\Subject;
use App\Models\Category;
use App\Models\Progress;
use App\Models\Question;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;
use App\Models\ContentCategory;
use App\Models\SplitExamAttempt;
use App\Traits\FileManagerTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\ModelCollection;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\studentExamResource;
use App\Http\Resources\AttemptsCourseResource;
use App\Repository\ContentRepositoryInterface;
use App\Http\Resources\AttemptsDetailsResource;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;

class ExamController extends Controller
{
    private $question ,$content ,$student_exam;

    public function __construct(ContentRepositoryInterface $content ,
    QuestionRepositoryInterface $question ,StudentExamRepositoryInterface $student_exam)
    {
        $this->question = $question;
        $this->content = $content;
        $this->student_exam = $student_exam;

        $auth = request()->hasHeader('Authorization');
        if($auth)
        {
            $this->middleware('jwt.verify')->only(['getExamattempts','attemptResult','attemptResult']);
        }
    }

    public function enterExam(Request $request, $id)
    {

        $exam = $this->content->getById($id);
        if (!($exam->attempts_count > $exam->getExamined())) {
            return response()->json([
                'data' => [
                    'msg' => __('lang.attemps_exceeded'),
                ],
            ]);
        }
        try
        {
            if(isset($exam))
            {
                $course = Course::where('id' , $exam->course_id)->first();
                if($course->subscribed())
                {
                    $cat = NULL ; $attempt = NULL; $is_last = false;

                    $another_exams = StudentExam::where([
                        'user_id' => JWTAuth::user()->id,
                        'status' => 1,
                        ['content_id' , '!=' , $id]
                    ])->orWhere('content_id' ,NULL)->get();

                    if($another_exams->count() > 0)
                    {
                        foreach($another_exams as $another_exam)
                        {
                            $another_exam->update(['status' => 0]);
                        }
                    }


                    if($exam->type == 'split_test')
                    {

                        $categories = ContentCategory::where('content_id',$exam->id)->get();
                        $attempts_count = SplitExamAttempt::where(['user_id' => JWTAuth::user()->id , 'content_id' => $exam->id])->first();
                        if($attempts_count && $attempts_count->split_attempts_counts == $categories->count())
                        {
                            $is_last = true;
                        }

                        $last_attempt = StudentExam::where(['content_id' => $exam->id,'user_id' => JWTAuth::user()->id ])->orderBy('id','desc')->first();

                        if($attempts_count && $attempts_count->split_attempts_counts == $categories->count() && $last_attempt->status == 0)
                        {
                            $attempts_count->delete();
                            return response()->json(['data' => __('lang.done_exam'),'status' => 200]);
                            //return redirect()->route('exam-attempts-site',$exam->id)->with('success', __('lang.done_exam'));
                        }

                        $categories_ids =  $categories->pluck('id')->toArray();
                        $attempts =  StudentExam::where(['content_id' => $exam->id,'status' => 0 , 'user_id' => JWTAuth::user()->id])->
                            whereIn('content_category_id',$categories->pluck('id')->toArray())->get();


                        if($categories->count() > 0)
                        {
                            foreach($categories as $category)
                            {
                                $questions = Question::where('content_category_id',$category->id)->get();
                                if($questions->count() < $category->questions_number)
                                {
                                    return response()->json(['data' => __('lang.all_questions_not_added'),'status' => 400]);
                                }
                            }

                            foreach($categories as $category)
                            {
                                $exist_attempts = StudentExam::where(['content_id' => $exam->id, 'status' => 0,'user_id' => JWTAuth::user()->id])->get();
                                if($exam->attempts_count == (int)($attempts->count() / $categories->count()) && $last_attempt->status == 0)
                                {
                                    $attempts_count->delete();
                                    return response()->json(['data' => __('lang.done_exam'),'status' => 400]);
                                }
                                else
                                {

                                    $last_attempt = StudentExam::where(['content_id' => $exam->id,'user_id' => JWTAuth::user()->id ])->orderBy('id','desc')->first();
                                    if($last_attempt)
                                    {

                                        if($last_attempt->content_category_id == end($categories_ids))
                                        {
                                            if($last_attempt->status == 0 && $attempts_count && $attempts_count->split_attempts_counts == 0)
                                            {
                                                $cat = ContentCategory::where('id',$category->id)->first();
                                                $attempt = $last_attempt->attempt + 1;
                                                $attempts_count->update(['split_attempts_counts' => $attempts_count->split_attempts_counts + 1]);
                                                // Session::put('split_attempts_counts', (Session::get('split_attempts_counts') + 1));
                                                break;
                                            }
                                            else
                                            {

                                                if($last_attempt->status == 0)
                                                {
                                                    if($attempts_count && $attempts_count->split_attempts_counts == $categories->count())
                                                    {

                                                    // $attempts_count->update(['split_attempts_counts' => 0]);
                                                        $attempts_count->delete();
                                                        // Session::put('split_attempts_counts', 0);
                                                        return response()->json(['data' => __('lang.done_exam'),'status' => 400]);
                                                    }

                                                    $cat = ContentCategory::where('id',$categories_ids[0])->first();
                                                    $attempt = $last_attempt->attempt + 1;

                                                    $new_attempts_count = new SplitExamAttempt;
                                                    $new_attempts_count->user_id = JWTAuth::user()->id;
                                                    $new_attempts_count->content_id = $exam->id;
                                                    $new_attempts_count->save();

                                                    $new_attempts_count->update(['split_attempts_counts' =>  1]);

                                                    break;
                                                }
                                                else
                                                {
                                                    //dd('adsad');
                                                    $cat = ContentCategory::where('id',$last_attempt->content_category_id)->first();
                                                    $attempt = $last_attempt->attempt;
                                                    break;
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if($last_attempt->status == 0)
                                            {
                                                $key = array_search($last_attempt->content_category_id, $categories_ids);
                                                $cat = ContentCategory::where('id',$categories_ids[$key+1])->first();
                                                $attempt = $last_attempt->attempt;
                                                $attempts_count->update(['split_attempts_counts' => $attempts_count->split_attempts_counts + 1]);
                                                break;
                                            }
                                            else
                                            {
                                                $cat = ContentCategory::where('id',$last_attempt->content_category_id)->first();
                                                break;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $cat = ContentCategory::where('id',$category->id)->first();
                                        $attempt = 1;
                                        $new_attempts_count = new SplitExamAttempt;
                                        $new_attempts_count->user_id = JWTAuth::user()->id;
                                        $new_attempts_count->content_id = $exam->id;
                                        $new_attempts_count->save();


                                        $new_attempts_count->update(['split_attempts_counts' =>  1]);
                                        // Session::put('split_attempts_counts', 1);
                                        break;
                                    }
                                }

                            }
                            $questions_count = $cat->questions_number;
                            $questions = Question::where('content_category_id',$cat->id)->get();
                        }
                        else
                        {
                            return response()->json(['data' => __('lang.all_questions_not_added'),'status' => 400]);
                        }
                    }


                    if($exam->type == 'exam' || $exam->type == 'homework')
                    {
                        $questions = Question::where('content_id',$exam->id)->get();
                        $questions_count = $exam->questions_number;
                    }

                    if($questions_count == $questions->count())
                    {
                        // check number of attemps for user
                        if($exam->type == 'split_test')
                        {
                            $status = StudentExam::where(['content_id' => $exam->id,'user_id' => JWTAuth::user()->id
                            ,'status' => 0 , 'content_category_id' => $cat->id])->first();
                        }
                        else
                        {
                            $status = StudentExam::where(['content_id' => $exam->id,'user_id' => JWTAuth::user()->id
                            ,'status' => 0])->first();
                        }


                        if($status)
                        {
                            $content = $this->content->getById($status->content_id);
                            if(isset($content))
                            {
                                $progress = Progress::where(['content_id' => $content->id, 'user_id' => JWTAuth::user()->id])->first();
                                if(!isset($progress))
                                {
                                    $new_progress = new Progress;
                                    $new_progress->user_id = JWTAuth::user()->id;
                                    $new_progress->content_id = $content->id;
                                    $new_progress->save();
                                }
                            }
                            //return back()->with('failed' , __('lang.exam_closed'));
                        }



                        if($exam->type == 'split_test')
                        {
                            $student_exam = StudentExam::where(['content_id' => $exam->id,'user_id' => JWTAuth::user()->id,'content_category_id' => $cat->id])->first();
                        }
                        else
                        {
                            $student_exam = StudentExam::where(['content_id' => $exam->id,'user_id' => JWTAuth::user()->id])->first();
                        }

                        if($student_exam)
                        {
                            $exam_status = StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 1])->first();
                            if(!$exam_status)
                            {
                                // save exam infos
                                $stu_exam = new StudentExam;
                                $stu_exam->user_id = JWTAuth::user()->id;
                                $stu_exam->status = 1;
                                $stu_exam->content_id = $exam->id;
                                $stu_exam->result = 0;
                                $stu_exam->total = 0;

                                if($exam->type == 'exam' || $exam->type == 'split_test')
                                {

                                    $cur_time=date("H:i:s");
                                    $curent=strtotime($cur_time);
                                    if($exam->type == 'split_test')
                                    {
                                        $duration='+'.$cat->exam_time. 'minutes';
                                        $stu_exam->content_category_id = $cat->id;
                                        $stu_exam->attempt = $attempt;
                                    }
                                    else
                                    {
                                        $duration='+'.$exam->exam_time. 'minutes';
                                    }
                                    $end= strtotime(date('H:i:s', strtotime($duration, strtotime($cur_time))));

                                    $stu_exam->start_at = $curent;
                                    $stu_exam->end_at = $end;
                                }
                                $stu_exam->save();

                                $student_exam_id = $stu_exam->id;
                                if($exam->type == 'split_test')
                                {
                                    $timer = $cat->exam_time;
                                }
                                else
                                {
                                    $timer = $exam->exam_time;
                                }
                                return response()->json(['data' => [
                                    'questions' =>  QuestionResource::collection($questions),
                                    'cat' => $cat->name ?? '',
                                    'exam' => $exam->id,
                                    'student_exam_id' => $student_exam_id,
                                    'timer' => $timer,
                                    'is_last' => $is_last
                                    ],'status' => 200]);

                            }
                            else
                            {


                                $questions_number = $exam_status->questions_number;
                                if($exam->type == 'exam' || $exam->type == 'split_test')
                                {

                                    $timer = number_format((float)(($exam_status->end_at - strtotime(date("H:i"))) / 60), 2, '.', '');
                                    if($timer <= 0){
                                        $exam_status->update(['status' => 0]);
                                        return $this->enterExam($request,$exam->id);
                                    }
                                }
                                else
                                {
                                    $timer = '';
                                }
                                $student_exam_id = $exam_status->id;

                                return response()->json(['data' => [
                                    'questions' =>  QuestionResource::collection($questions),
                                    'cat' => $cat->name ?? '',
                                    'exam' => $exam->id,
                                    'student_exam_id' => $student_exam_id,
                                    'timer' => $timer ,
                                    'is_last' => $is_last
                                ],'status' => 200]);
                            }

                        }
                        else
                        {
                            // save exam infos
                            $stu_exam = new StudentExam;
                            $stu_exam->user_id = JWTAuth::user()->id;
                            $stu_exam->status = 1;
                            $stu_exam->content_id = $exam->id;
                            $stu_exam->result = 0;
                            $stu_exam->total = 0;

                            if($exam->type == 'exam' || $exam->type == 'split_test')
                            {
                                $cur_time=date("H:i:s");
                                $curent=strtotime($cur_time);
                                if($exam->type == 'split_test')
                                {
                                    $duration='+'.$cat->exam_time. 'minutes';
                                    $stu_exam->content_category_id = $cat->id;
                                    $stu_exam->attempt = $attempt;
                                }
                                else
                                {
                                    $duration='+'.$exam->exam_time. 'minutes';
                                }
                                $end= strtotime(date('H:i:s', strtotime($duration, strtotime($cur_time))));

                                $stu_exam->start_at = $curent;
                                $stu_exam->end_at = $end;
                            }
                            $stu_exam->save();

                            $student_exam_id = $stu_exam->id;
                            if($exam->type == 'split_test')
                            {
                                $timer = $cat->exam_time;
                            }
                            else
                            {
                                $timer = $exam->exam_time;
                            }
                            return response()->json(['data' => [
                                'questions' =>  QuestionResource::collection($questions),
                                'cat' => $cat->name ?? '',
                                'exam' => $exam->id,
                                'student_exam_id' => $student_exam_id,
                                'timer' => $timer ,
                                'is_last' => $is_last
                            ],'status' => 200]);
                        }

                    }
                    else
                    {
                        return response()->json(['data' => __('lang.all_questions_not_added'),'status' => 400]);
                    }

                }
                else
                {
                    return response()->json(['data' => __('lang.you_are_not_subscribed'),'status' => 400]);
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



    public function SubmitExam(Request $request)
    {

        $student_exam = $this->student_exam->getById($request->exam_id);
        $unit = Content::where('id' , $student_exam->content_id)->first();
        $content = $this->content->getById($student_exam->content_id);
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

                $question->attemp_id = $request->exam_id;
                $question->save();
            }

            $student_exam = $this->student_exam->getById($request->exam_id);
            $student_exam->update(['status' => 0]);

            $content = $this->content->getById($student_exam->content_id);
            if(isset($content))
            {
                $progress = Progress::where(['content_id' => $content->id, 'user_id' => JWTAuth::user()->id])->first();
                if(!isset($progress))
                {
                    $new_progress = new Progress;
                    $new_progress->user_id = JWTAuth::user()->id;
                    $new_progress->content_id = $content->id;
                    $new_progress->save();
                }
            }

            if(isset($student_exam->content_category_id))
            {
                return $this->enterExam($request,$content->id);
                // return redirect()->route('course-exam',$content->id)->with('success', __('lang.cat_ans_sent'));
            }

            return response()->json(['data' => __('lang.done_exam'),'status' => 200]);
            // return redirect()->route('exam-attempts-site',$content->id)->with('success', __('lang.done_exam'));

        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }



    // get exam attempts
    public function getExamattempts($id)
    {
        $user = JWTAuth::user();
         try
         {
             $content = $this->content->getById($id);
             if(isset($content))
             {
                $attempts = StudentExam::where(['content_id' => $content->id , 'user_id' => $user->id , 'status' => 0])->get();
                if($content->type == 'split_test')
                {
                    $count_attempts = array_values(array_unique($attempts->pluck('attempt')->toArray()));
                    if(sizeof($count_attempts) > 0)
                    {
                        $attempts_arr = [];
                        for ($i = 0; $i < sizeof($count_attempts); $i++)
                        {
                            $categories = ContentCategory::where('content_id',$content->id)->get();
                            $attempts =  StudentExam::where(['content_id' => $content->id,'status' => 0 , 'user_id' => $user->id])->
                            whereIn('content_category_id',$categories->pluck('id')->toArray())->orderBy('id','desc')->get();
                            $cats_attempt = StudentExam::where([
                                'content_id' => $content->id,
                                'status' => 0 ,
                                'user_id' => $user->id,
                                'attempt' => $count_attempts[$i],
                                ])->whereIn('content_category_id',$categories->pluck('id')->toArray())->get();

                                $questions = Question::whereIn('content_category_id',$categories->pluck('id')->toArray())->get();
                                $answers = StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->get();
                                $right_answers = StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->where(['type' => '1'])->get();

                                $wrong_answers = StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->where(['type' => '0'])->where('student_answer', '!=', 'not_answered')->get();
                                $uncompleted_answers = StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->where(['student_answer' => 'not_answered'])->get();

                                if(array_sum($questions->pluck('degree')->toArray()) > 0)
                                {
                                    $total = (array_sum($answers->pluck('teacher_degree')->toArray())  / array_sum($questions->pluck('degree')->toArray())) * 100;
                                    $total = number_format($total, 2);
                                }
                                else
                                {
                                    $total = 0;
                                }


                                array_push($attempts_arr,
                                [
                                    'attempt_id' => $count_attempts[$i],
                                    'total' => $total . ' %',
                                    'right_answers' => count($right_answers),
                                    'wrong_answers' => count($wrong_answers),
                                    'uncompleted_answers' => count($uncompleted_answers),
                                    'content_id' => $content->id,
                                    'unit_id' => $content->parent->parent->parent->id,
                                ]);
                        }
                        return response()->json(['data' => $attempts_arr
                        ,'status' => 200]);;
                    }
                }
                else
                {
                    return response()->json(['data' => AttemptsCourseResource::collection($attempts) ,'status' => 200]);
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

        // get exam controller

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


                    if($exam->content->type == 'exam' || $exam->content->type == 'homework')
                    {
                        $questions = Question::where('content_id',$exam->content_id)->get();
                    }
                    else
                    {
                        $questions = Question::where('content_category_id',$exam->content_category_id)->get();
                    }
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
                                'right_answers' => count($right_answers),
                                'wrong_answers' => count($wrong_answers),
                                'uncompleted_answers' => count($uncompleted_answers),
                                'subjects_analysis' => $subjects_analysis,
                                'content_id' => $exam->content_id,
                                'unit_id' => $exam->content->parent->parent->parent->id,

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


    public function examDetailsattempts($id,$attempt_number)
    {
        $content = $this->content->getById($id);
        try
        {
            if(isset($content) &&  $content->type == 'split_test')
            {
                $attempts = StudentExam::where(['content_id' => $content->id , 'attempt' => $attempt_number ,'user_id' => JWTAuth::user()->id , 'status' => 0])->get();
                if($attempts)
                {
                    return response()->json(['data' => AttemptsCourseResource::collection($attempts) ,'status' => 200]);
                }
                else
                {
                    return response()->json(['data' => __('lang.not_found'),'status' => 400]);
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
