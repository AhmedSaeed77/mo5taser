<?php

namespace App\Http\Controllers\Admin\Rating;

use App\Models\Course;
use App\Models\Rating;
use App\Scopes\ActiveScope;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\CourseRepositoryInterface;
use App\Repository\RatingRepositoryInterface;

class RatingController extends Controller
{
    private $rating;

    public function __construct(RatingRepositoryInterface $rating)
    {
        $this->rating = $rating;
    }

    public function show($id)
    {
        try
        {
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $ratings = Rating::where('course_id',$course->id)->get();
                return view('dashboard.courses.ratings.index',compact('ratings','course'));
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

    public function destroy($id)
    {
        try
        {
            $rating = $this->rating->getById($id);
            if(isset($rating))
            {
                $this->rating->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
