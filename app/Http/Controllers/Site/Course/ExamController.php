<?php

namespace App\Http\Controllers\Site\Course;

use App\Notifications\StudentTestCorrection;
use Session;
use App\Models\Course;
use App\Models\Content;
use App\Models\Category;
use App\Models\Progress;
use App\Models\Question;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;
use App\Models\ContentCategory;
use App\Models\SplitExamAttempt;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\ContentRepositoryInterface;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentExamRepositoryInterface;
use App\Repository\SplitExamAttemptRepositoryInterface;

class ExamController extends Controller
{
    private $question ,$content ,$student_exam ,$split_exam;

    public function __construct(ContentRepositoryInterface $content ,
    QuestionRepositoryInterface $question ,StudentExamRepositoryInterface $student_exam ,SplitExamAttemptRepositoryInterface $split_exam)
    {
        $this->question = $question;
        $this->content = $content;
        $this->student_exam = $student_exam;
        $this->split_exam = $split_exam;
    }

    public function enterExam(Request $request, $id)
    {

        $exam = $this->content->getById($id);
        try
        {

            //dd(Session::get('split_attempts_counts'));
            if(isset($exam))
            {
                $course = Course::where('id' , $exam->course_id)->first();
                if($course->subscribed())
                {
                    $cat = NULL;
                    $attempt = NULL;

                    $another_exams = StudentExam::where([
                        'user_id' => auth()->id(),
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
                        $attempts_count = SplitExamAttempt::where(['user_id' => auth()->id() , 'content_id' => $exam->id])->first();
                        $last_attempt = StudentExam::where(['content_id' => $exam->id,'user_id' => auth()->id() ])->orderBy('id','desc')->first();

                        //dd($attempts_count);

                        if($attempts_count && $attempts_count->split_attempts_counts == $categories->count() && $last_attempt->status == 0)
                        {
                            $attempts_count->delete();
                            return redirect()->route('exam-attempts-site',$exam->id)->with('success', __('lang.done_exam'));
                        }
                        $categories_ids =  $categories->pluck('id')->toArray();
                        $attempts =  StudentExam::where(['content_id' => $exam->id,'status' => 0 , 'user_id' => auth()->id()])->
                            whereIn('content_category_id',$categories->pluck('id')->toArray())->get();


                        if($categories->count() > 0)
                        {
                            foreach($categories as $category)
                            {
                                $questions = Question::where('content_category_id',$category->id)->get();
                                if($questions->count() < $category->questions_number)
                                {
                                    return back()->with('failed' , __('lang.all_questions_not_added'));
                                }
                            }

                            foreach($categories as $category)
                            {
                                $exist_attempts = StudentExam::where(['content_id' => $exam->id, 'status' => 0,'user_id' => auth()->id()])->get();
                                if($exam->attempts_count == (int)($attempts->count() / $categories->count()) && $last_attempt->status == 0)
                                {
                                    $attempts_count->delete();
                                    return redirect()->route('exam-attempts-site',$exam->id)->with('success', __('lang.done_exam'));
                                }
                                else
                                {
                                    $last_attempt = StudentExam::where(['content_id' => $exam->id,'user_id' => auth()->id() ])->orderBy('id','desc')->first();
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
                                                        return redirect()->route('exam-attempts-site',$exam->id)->with('success', __('lang.done_exam'));
                                                    }

                                                    $cat = ContentCategory::where('id',$categories_ids[0])->first();
                                                    $attempt = $last_attempt->attempt + 1;
                                                    $new_attempts_count = new SplitExamAttempt;
                                                    $new_attempts_count->user_id = auth()->id();
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
                                                if($attempts_count)
                                                {
                                                    $attempts_count->update(['split_attempts_counts' => $attempts_count->split_attempts_counts + 1]);
                                                }
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
                                        $new_attempts_count->user_id = auth()->id();
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
                            return back()->with('failed' , __('lang.all_questions_not_added'));
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
                            $status = StudentExam::where(['content_id' => $exam->id,'user_id' => auth()->id()
                            ,'status' => 0 , 'content_category_id' => $cat->id])->first();
                        }
                        else
                        {
                            $status = StudentExam::where(['content_id' => $exam->id,'user_id' => auth()->id()
                            ,'status' => 0])->first();
                        }


                        if($status)
                        {
                            $content = $this->content->getById($status->content_id);
                            if(isset($content))
                            {
                                $progress = Progress::where(['content_id' => $content->id, 'user_id' => auth()->id()])->first();
                                if(!isset($progress))
                                {
                                    $new_progress = new Progress;
                                    $new_progress->user_id = auth()->id();
                                    $new_progress->content_id = $content->id;
                                    $new_progress->save();
                                }
                            }
                            //return back()->with('failed' , __('lang.exam_closed'));
                        }



                        if($exam->type == 'split_test')
                        {
                            $student_exam = StudentExam::where(['content_id' => $exam->id,'user_id' => auth()->id(),'content_category_id' => $cat->id])->first();
                        }
                        else
                        {
                            $student_exam = StudentExam::where(['content_id' => $exam->id,'user_id' => auth()->id()])->first();
                        }

                        if($student_exam)
                        {
                            $exam_status = StudentExam::where(['user_id' => auth()->id(),'status' => 1])->first();
                            if(!$exam_status)
                            {
                                // save exam infos
                                $stu_exam = new StudentExam;
                                $stu_exam->user_id = auth()->id();
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
                                return view('site.courses.exams.exam_page',compact('questions','cat','exam','student_exam_id','timer'));

                            }
                            else
                            {


                                $questions_number = $exam_status->questions_number;
                                if($exam->type == 'exam' || $exam->type == 'split_test')
                                {

                                    $timer = number_format((float)(($exam_status->end_at - strtotime(date("H:i"))) / 60), 2, '.', '');
                                    if($timer <= 0){
                                        $exam_status->update(['status' => 0]);
                                        return redirect()->route('course-exam',$exam->id);
                                    }
                                }
                                else
                                {
                                    $timer = '';
                                }
                                $student_exam_id = $exam_status->id;
                                return view('site.courses.exams.exam_page',compact('questions','cat','exam','student_exam_id','timer'));
                            }

                        }
                        else
                        {
                            // save exam infos
                            $stu_exam = new StudentExam;
                            $stu_exam->user_id = auth()->id();
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
                            return view('site.courses.exams.exam_page',compact('questions','exam','cat','student_exam_id','timer'));
                        }

                    }
                    else
                    {
                        return back()->with('failed' , __('lang.all_questions_not_added'));
                    }

                }
                else
                {
                    return back()->with('failed' , __('lang.you_are_not_subscribed'));
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

        $student_exam = $this->student_exam->getById($request->exam_id);
        $unit = Content::where('id' , $student_exam->content_id)->first();
        $content = $this->content->getById($student_exam->content_id);
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

            $content = $this->content->getById($student_exam->content_id);
            if(isset($content))
            {
                $progress = Progress::where(['content_id' => $content->id, 'user_id' => auth()->id()])->first();
                if(!isset($progress))
                {
                    $new_progress = new Progress;
                    $new_progress->user_id = auth()->id();
                    $new_progress->content_id = $content->id;
                    $new_progress->save();
                }
            }

            if(isset($student_exam->content_category_id))
            {
                return redirect()->route('course-exam',$content->id)->with('success', __('lang.cat_ans_sent'));
            }

            return redirect()->route('exam-attempts-site',$content->id)->with('success', __('lang.done_exam'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    // get exam controller
    public function getExamattempts($id)
    {
        $notifications = auth()->user()->Notifications()->where('type', StudentTestCorrection::class)->get();
        foreach($notifications as $notification) {
            if($notification->data['id'] == $id)
                $notification->markAsRead();
        }
        try
        {
            $content = $this->content->getById($id);

            if(isset($content))
            {
                $attempts = StudentExam::where(['content_id' => $content->id , 'user_id' => auth()->id() , 'status' => 0])->orderBy('id','desc')->get();
                return view('site.courses.single.attempts',compact('attempts','content'));

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

    public function examDetailsattempts($id,$attempt_number)
    {
        $content = $this->content->getById($id);
        try
        {
            if(isset($content) &&  $content->type == 'split_test')
            {
                $attempts = StudentExam::where(['content_id' => $content->id , 'attempt' => $attempt_number ,'user_id' => auth()->id() , 'status' => 0])->orderBy('id','desc')->get();
                if($attempts)
                {
                    return view('site.courses.single.attempts-details',compact('attempts','content','attempt_number'));
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


    public function attemptResult($id)
    {
        $exam = $this->student_exam->getById($id);
        try
        {
            if(isset($exam))
            {
                if($exam->user_id == auth()->id())
                {
                    $answers = StudentAnswer::where(['attemp_id' => $exam->id])->get();
                    if($exam->content_category_id)
                    {
                        return view('site.courses.single.exam_result_split',compact('answers','exam'));
                    }
                    return view('site.courses.single.exam_result',compact('answers','exam'));
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
