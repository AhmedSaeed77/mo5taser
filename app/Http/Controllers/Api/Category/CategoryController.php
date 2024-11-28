<?php

namespace App\Http\Controllers\Api\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\CategoryResource;
use App\Repository\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $cat ,$student_exam,$question;

    public function __construct(CategoryRepositoryInterface $cat)
    {
        $this->cat = $cat;
    }

    public function show($id)
    {
        try
        {
            $cat = $this->cat->getById($id);
            if($cat)
            {
                $cats = Category::where('parent_id',$cat->id)->get();
                return response()->json(['data' => new ModelCollection(CategoryResource::collection($cats)),'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.not_found_cat'),'status' => 400]);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
