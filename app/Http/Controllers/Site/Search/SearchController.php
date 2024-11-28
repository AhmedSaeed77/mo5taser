<?php

namespace App\Http\Controllers\Site\Search;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

    public function search(Request $request)
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
                        $query->orWhere(function ($query) use ($search) {
                            return $query->where(function($q) use ($search){
                                return $q->where('desc_ar',"LIKE" , '%'.$search.'%')
                                    ->orWhere('desc_en',"LIKE" , '%'.$search.'%');
                            });
                        });
                    })->get();

                return view('site.search.index',compact('courses','search'));
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
