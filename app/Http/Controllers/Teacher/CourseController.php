<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Course;
use App\Models\PassExam;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\AdminRepositoryInterface;
use App\Repository\SubjectRepositoryInterface;
use App\Repository\PassExamRepositoryInterface;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::whereHas('teachers',function($q){
            return $q->where('course_teachers.teacher_id',auth()->id());
        })->withoutGlobalScope(ActiveScope::class)->get();
        return view('teachers.courses.index',compact('courses'));
    }

}
