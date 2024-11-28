<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\SubjectRepositoryInterface;
use App\Http\Requests\Question\QuestionRequest;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;

class QuestionsController extends Controller
{
    use FileManagerTrait;
    private $question ,$pass;

    public function __construct(PassExamRepositoryInterface $pass ,
    QuestionRepositoryInterface $question ,
    SubjectRepositoryInterface $subject)
    {
        $this->question = $question;
        $this->pass = $pass;
        $this->subject = $subject;
    }

    public function edit($id)
    {
        try
        {
            $question = $this->question->getById($id);
            if($question->type == 'matching')
            {
                $questions = json_decode($question->question);
            }
            else
            {
                $questions = [];
            }
            if(isset($question))
            {
                $exam = $this->pass->getById($question->exam_id);
                $subjects = Subject::where('Parent_id',NULL)->get();
                return view('teachers.passed_exams.questions.edit',compact('question','exam','subjects','questions'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    private function getVideoId($url)
    {
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?.*v=|embed\/|v\/))([^\s&]+)/', $url, $matches)) {
            return $matches[1]; // YouTube video ID
        } elseif (preg_match('/(?:vimeo\.com\/(?:channels\/|groups\/|album\/\d+\/video\/|video\/|ondemand\/|video\/|))(\d+)/', $url, $matches)) {
            return $matches[1]; // Vimeo video ID
        }

        return $url;
    }

    public function store(QuestionRequest $request)
    {
        try
        {
            $data = [
                'question' => $request->question,
                'question_details' => $request->question_details,
                'answer1' => $request->answer1,
                'answer2' => $request->answer2,
                'answer3' => $request->answer3,
                'answer4' => $request->answer4,
                'true_answer' => $request->true_answer,
                'subject_id' => max($request->subject_id),
                'exam_id' => $request->exam_id,
                'degree' => $request->degree,
                'video_platform' => $request->video_platform,
                'video_url' => $request->video_url,
                'video_id' => $this->getVideoId($request->video_url),
                'type' => $request->type,
                'hint' => $request->hint,
                'hint_video' => $request->hint_video,
                'hint_video_platform' => $request->hint_video_platform,
                'hint_video_id' => $this->getVideoId($request->hint_video),
                'image' => $this->upload('image','questions'),
                'hint_image' => $this->upload('hint_image','questions'),
            ];

            $this->question->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(QuestionRequest $request,$id)
    {
        try
        {
            $question = $this->question->getById($id);
            if(isset($question))
            {
                $data = [
                    'question' => $request->question,
                    'question_details' => $request->question_details,
                    'answer1' => $request->answer1,
                    'answer2' => $request->answer2,
                    'answer3' => $request->answer3,
                    'answer4' => $request->answer4,
                    'true_answer' => $request->true_answer,
                    'subject_id' => max($request->subject_id),
                    'exam_id' => $request->exam_id,
                    'degree' => $request->degree,
                    'video_platform' => $request->video_platform,
                    'video_url' => $request->video_url,
                    'video_id' => $this->getVideoId($request->video_url),
                    'type' => $request->type,
                    'hint' => $request->hint,
                    'hint_video' => $request->hint_video,
                    'hint_video_platform' => $request->hint_video_platform,
                    'hint_video_id' => $this->getVideoId($request->hint_video),
                    'image' => $request->image ?  $this->updateFile('image','questions',$question->image) : $question->image,
                    'hint_image' => $request->hint_image ?  $this->updateFile('hint_image','questions',$question->hint_image) : $question->hint_image,
                ];

                $this->question->update($id,$data);
                return back()->with('success' , __('lang.updated'));
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
