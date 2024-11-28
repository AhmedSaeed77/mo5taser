<?php

namespace App\Http\Controllers\Site\News;

use App\Models\News;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\NewsRepositoryInterface;

class NewsController extends Controller
{
    use FileManagerTrait;
    private $news;

    public function __construct(NewsRepositoryInterface $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        try
        {
            $news = News::query()->orderByDesc('updated_at')->paginate(8);
            return view('site.news.index',compact('news'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function show($id)
    {
        try
        {
            $new = $this->news->getById($id);
            if(isset($new))
            {
                $latest_news = News::where('id','!=', $id)->latest()->take(4)->get();
                return view('site.news.show',compact('new','latest_news'));
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
