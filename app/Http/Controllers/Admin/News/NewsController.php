<?php

namespace App\Http\Controllers\Admin\News;

use App\Models\News;
use App\Models\Team;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\NewsRequest;
use App\Repository\NewsRepositoryInterface;

class NewsController extends Controller
{
    use FileManagerTrait;
    private $new;

    public function __construct(NewsRepositoryInterface $new)
    {
        $this->new = $new;
    }

    public function index()
    {
        try
        {
            $news = $this->new->getAll();
            return view('dashboard.news.index',compact('news'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        try
        {
            $new = News::find($id);
            if(isset($new))
            {
                $new = $this->new->getById($id);
                return view('dashboard.news.edit',compact('new'));
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

    public function store(NewsRequest $request)
    {
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'content_ar' => $request->content_ar,
                'content_en' => $request->content_en,
                'image' => $this->upload('image','news'),
            ];

            $this->new->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(NewsRequest $request,$id)
    {
        try
        {
            $new = News::find($id);
            if(isset($new))
            {
                $data = [
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                    'content_ar' => $request->content_ar,
                    'content_en' => $request->content_en,
                    'image' => $request->image ?  $this->updateFile('image','news',$new->image) : $new->image,
                ];

                $this->new->update($id,$data);
                return redirect()->route('news.index')->with('success' , __('lang.updated'));
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
            $new = News::find($id);
            if(isset($new))
            {
                $this->new->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
