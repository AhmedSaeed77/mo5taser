<?php

namespace App\Http\Controllers\Api\Search;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ModelCollection;
use App\Http\Requests\Search\SearchRequest;
use App\Http\Resources\CoursePaginateCollection;

class SearchController extends Controller
{

    public function search(SearchRequest $request)
    {
        $search = $request->search;
        try
        {
            if(isset($search))
            {
                $courses = Course::when($search != null, function ($query) use ($search) {
                    return $query->where(function($q) use ($search){
                          return $q->where('title_ar',"LIKE" , '%'.$search.'%')
                          ->orWhere('title_en',"LIKE" , '%'.$search.'%');
                        });
                    })
                    ->when($search != null, function ($query) use ($search) {
                        return $query->orWhere(function($q) use ($search){
                              return $q->where('desc_ar',"LIKE" , '%'.$search.'%')
                              ->orWhere('desc_en',"LIKE" , '%'.$search.'%');
                            });
                    })->paginate(9);

                    return new CoursePaginateCollection($courses);
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
