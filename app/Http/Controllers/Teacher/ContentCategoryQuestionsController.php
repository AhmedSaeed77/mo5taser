<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Content;
use App\Models\Subject;
use App\Models\Question;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Content\ContentRequest;
use App\Repository\ContentRepositoryInterface;
use App\Repository\SubjectRepositoryInterface;
use App\Http\Requests\Question\QuestionRequest;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\ContentCategoryRepositoryInterface;

class ContentCategoryQuestionsController extends Controller
{
    use FileManagerTrait;
    private $content,$question,$subject,$category;
    public function __construct(ContentRepositoryInterface $content,QuestionRepositoryInterface $question,
    SubjectRepositoryInterface $subject ,ContentCategoryRepositoryInterface $category)
    {
        $this->content = $content;
        $this->question = $question;
        $this->subject = $subject;
        $this->category = $category;
    }

    public function CreateQuestions($id)
    {
        $category = $this->category->getById($id);
        try
        {
            if(isset($category))
            {
                $questions = Question::where('content_category_id',$category->id)->get()->count();
                $subjects = Subject::where('Parent_id',NULL)->get();
                return view('teachers.courses_content.exam_categories.exam_questions.questions.create',compact('questions','category','subjects'));
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

    public function show($id)
    {
        try
        {
            $category = $this->category->getById($id);
            if(isset($category))
            {
                $content =  Content::withoutGlobalScope(ActiveScope::class)->where('id',$category->content->id)->first();
                $questions = Question::where('content_category_id',$category->id)->get();
                return view('teachers.courses_content.exam_categories.exam_questions.index',compact('questions','category','content'));
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

    public function edit($id)
    {
        $question = $this->question->getById($id);
        try
        {
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
                $category = $this->category->getById($question->content_category_id);
                $subjects = Subject::where('Parent_id',NULL)->get();
                return view('teachers.courses_content.exam_categories.exam_questions.edit',compact('question','category','subjects','questions'));
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
                'content_category_id' => $request->content_category_id,
                'degree' => $request->degree,
                'video_url' => $request->video_url,
                'type' => $request->type,
                'hint_video' => $request->hint_video,
                'hint' => $request->hint,
                'image' => $this->upload('image','questions'),
                'hint_image' => $this->upload('hint_image','questions'),
                'video_platform' => $request->video_platform,
                'video_id' => $this->getVideoId($request->video_url),
                'hint_video_platform' => $request->hint_video_platform,
                'hint_video_id' => $this->getVideoId($request->hint_video),
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
        $question = $this->question->getById($id);
        try
        {
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
                    'content_category_id' => $request->content_category_id,
                    'degree' => $request->degree,
                    'video_url' => $request->video_url,
                    'type' => $request->type,
                    'hint_video' => $request->hint_video,
                    'hint' => $request->hint,
                    'image' => $request->image ?  $this->updateFile('image','questions',$question->image) : $question->image,
                    'hint_image' => $request->hint_image ?  $this->updateFile('hint_image','questions',$question->hint_image) : $question->hint_image,
                    'video_platform' => $request->video_platform,
                    'video_id' => $this->getVideoId($request->video_url),
                    'hint_video_platform' => $request->hint_video_platform,
                    'hint_video_id' => $this->getVideoId($request->hint_video),
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
            $content =  Content::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($content))
            {
                $this->content->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
