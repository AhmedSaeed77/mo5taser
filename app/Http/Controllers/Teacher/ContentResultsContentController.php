<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Course;
use App\Models\Content;
use App\Models\StudentExam;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\ContentRepositoryInterface;

class ContentResultsContentController extends Controller
{
    use FileManagerTrait;
    private $content;
    public function __construct(ContentRepositoryInterface $content)
    {
        $this->content = $content;
    }

    public function show($id)
    {
        try
        {
            $content = Content::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($content))
            {
                $results = StudentExam::where(['content_id' => $content->id,'status' => 0])->get();
                return view('teachers.courses_content.student_results.index',compact('results','content'));
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

}
