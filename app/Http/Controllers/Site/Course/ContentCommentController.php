<?php

namespace App\Http\Controllers\Site\Course;

use Illuminate\Http\Request;
use App\Models\ContentComment;
use App\Http\Controllers\Controller;
use App\Repository\ContentCommentRepositoryInterface;

class ContentCommentController extends Controller
{
    public $comment;
    public function __construct(ContentCommentRepositoryInterface $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request)
    {
        try
        {
            $data = [
                'comment' => $request->comment,
                'content_id' => $request->content_id,
                'user_id' => auth()->id(),
            ];

            $this->comment->create($data);
            $comments = ContentComment::where(['content_id' => $request->content_id , 'parent_id' => NULL])->orderBy('id','desc')->get();
            $result = view('site.courses.single.comments',compact('comments'))->render();
            return response()->json(['added',$result]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['err']);
        }
    }

    public function commentReply(Request $request)
    {
        try
        {
            $data = [
                'comment' => $request->comment,
                'content_id' => $request->content_id,
                'parent_id' => $request->parent_id,
                'user_id' => auth()->id(),
            ];

            $this->comment->create($data);
            $comments = ContentComment::where(['content_id' => $request->content_id , 'parent_id' => $request->parent_id])->orderBy('id','desc')->get();
            $result = view('site.courses.single.comments_replies',compact('comments'))->render();
            return response()->json(['added',$result]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['err']);
        }
    }
}

