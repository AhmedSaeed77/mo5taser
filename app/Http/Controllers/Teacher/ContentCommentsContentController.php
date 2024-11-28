<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Course;
use App\Models\Content;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Models\ContentComment;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Content\ContentRequest;
use App\Repository\ContentRepositoryInterface;
use App\Repository\ContentCommentRepositoryInterface;

class ContentCommentsContentController extends Controller
{
    use FileManagerTrait;
    private $content , $comment;
    public function __construct(ContentRepositoryInterface $content , ContentCommentRepositoryInterface $comment)
    {
        $this->content = $content;
        $this->comment = $comment;
    }

    public function show($id)
    {
        $content = Content::withoutGlobalScope(ActiveScope::class)->where('id',$id)->first();
        try
        {
            if(isset($content))
            {
                $comments = ContentComment::where(['content_id' => $content->id , 'parent_id' => NULL])->get();
                return view('teachers.courses_content.comments.index',compact('comments','content'));
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
        $master_comment =  $this->comment->getById($id);
        try
        {
            if(isset($master_comment))
            {
                $content = Content::withoutGlobalScope(ActiveScope::class)->where('id',$master_comment->content_id)->first();
                $comments = ContentComment::where(['parent_id' => $master_comment->id])->get();
                return view('teachers.courses_content.comments.replies',compact('comments','content','master_comment'));
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

    public function store(Request $request)
    {
        try
        {
            $data = [
                'comment' => $request->comment,
                'content_id' => $request->content_id,
                'parent_id' => $request->parent_id,
                'teacher_id' => auth()->id(),
            ];

            $this->comment->create($data);
            return back()->with('success' , __('lang.added'));
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
            $comment =  $this->comment->getById($id);
            if(isset($comment))
            {
                $this->comment->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
