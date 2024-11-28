<?php

namespace App\Http\Controllers\Api\News;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\NewsPaginateCollection;

class NewsController extends Controller
{
    public function index()
    {
        try
        {
            $news = News::query()->orderByDesc('created_at')->paginate(6);
            return new NewsPaginateCollection($news);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        try
        {
            if(isset($news))
            {
                return response()->json(['data' => new NewsResource($news),'status' => 200]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
