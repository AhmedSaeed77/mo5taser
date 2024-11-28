<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;
use App\Repository\CourseRepositoryInterface;

class Course extends Component
{
    public $course;

    public function __construct(CourseRepositoryInterface $course)
    {
        $this->course = $course;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $courses = $this->course->getAll();
        $categories = Category::category('course')->whereHas('courses')->with('courses')->get();
        return view('components.course', compact('courses', 'categories'));
    }
}
