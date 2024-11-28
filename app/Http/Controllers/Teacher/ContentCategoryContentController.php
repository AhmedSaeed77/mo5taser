<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Models\ContentCategory;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\ContentCategoryRepositoryInterface;

class ContentCategoryContentController extends Controller
{
    use FileManagerTrait;
    private $category;
    public function __construct(ContentCategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }

    public function show($id)
    {
        $content = Content::withoutGlobalScope(ActiveScope::class)->where('id',$id)->first();
        try
        {
            if(isset($content))
            {
                $categories = ContentCategory::where(['content_id' => $content->id])->get();
                return view('teachers.courses_content.exam_categories.index',compact('categories','content'));
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
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'questions_number' => $request->questions_number,
                'content_id' => $request->content_id,
                'exam_time' => $request->exam_time,
            ];

            $this->category->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(Request $request,$id)
    {
        $category =  $this->category->getById($id);
        try
        {
            if(isset($category))
            {
                $data = [
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'questions_number' => $request->questions_number,
                    'exam_time' => $request->exam_time,
                ];

                $this->category->update($id,$data);
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
        $category =  $this->category->getById($id);
        try
        {
            if(isset($category))
            {
                $this->category->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
