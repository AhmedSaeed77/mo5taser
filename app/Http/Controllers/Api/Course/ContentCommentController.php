<?php

namespace App\Http\Controllers\Api\Course;

use Illuminate\Http\Request;
use App\Models\ContentComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\ContentCommentResource;
use App\Repository\ContentRepositoryInterface;
use App\Http\Requests\Comment\CommentReplyRequest;
use App\Repository\ContentCommentRepositoryInterface;

class ContentCommentController extends Controller
{
    public $comment,$content;
    public function __construct(ContentCommentRepositoryInterface $comment,ContentRepositoryInterface $content)
    {
        $this->comment = $comment;
        $this->content = $content;
    }

    public function store(CommentRequest $request)
    {
        $content = $this->content->getById($request->content_id);
        try
        {
            if(isset($content))
            {
                $data = [
                    'comment' => $request->comment,
                    'content_id' => $request->content_id,
                    'user_id' => auth()->id(),
                ];

                $this->comment->create($data);
                $comments = ContentComment::where(['content_id' => $request->content_id , 'parent_id' => NULL])->orderBy('id','desc')->get();
                return response()->json(['data' => ContentCommentResource::collection($comments),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function commentReply(CommentReplyRequest $request)
    {
        $comment = $this->comment->getById($request->parent_id);
        try
        {
            if(isset($comment))
            {
                $data = [
                    'comment' => $request->comment,
                    'content_id' => $comment->content_id,
                    'parent_id' => $comment->id,
                    'user_id' => auth()->id(),
                ];

                $this->comment->create($data);
                $comments = ContentComment::where(['content_id' => $comment->content_id , 'parent_id' => NULL])->orderBy('id','desc')->get();
                return response()->json(['data' => ContentCommentResource::collection($comments),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}

