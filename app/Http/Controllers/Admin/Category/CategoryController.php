<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\PassExam;
use App\Models\Team;
use App\Models\WhyUs;
use App\Models\Category;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Why\WhyRequest;
use App\Http\Requests\Team\TeamRequest;
use App\Repository\WhyRepositoryInterface;
use App\Repository\TeamRepositoryInterface;
use App\Http\Requests\Category\CategoryRequest;
use App\Repository\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    use FileManagerTrait;
    private $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }

    public function CategoryByType($type)
    {
        try
        {
            $categories = Category::category($type)->get();
            $main_categories = Category::category($type)->where('parent_id',NULL)->get();
            return view('dashboard.categories.index',compact('categories','type','main_categories'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        try
        {
            $category = Category::find($id);
            if(isset($category))
            {
                $category = $this->category->getById($id);
                $categories = Category::category($category->type)->get();
                $main_categories = Category::category($category->type)->where('parent_id',NULL)->get();
                return view('dashboard.categories.edit',compact('category','categories','main_categories'));
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

    public function store(CategoryRequest $request)
    {
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'type' => $request->type,
                'parent_id' => $request->parent_id,
                'image' => $this->upload('image','categories'),
            ];


            $this->category->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(CategoryRequest $request,$id)
    {
        try
        {
            $category = Category::find($id);
            if(isset($category))
            {
                $data = [
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                    'type' => $request->type,
                    'parent_id' => $request->parent_id,
                    'image' => $request->image ?  $this->updateFile('image','categories',$category->image) : $category->image,
                ];

                $this->category->update($id,$data);
                PassExam::query()->where('level', $id)->update(['main_cat' => $request->parent_id]);
                return redirect()->route('category.type',$category->type)->with('success' , __('lang.updated'));
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
            $category = Category::find($id);
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
