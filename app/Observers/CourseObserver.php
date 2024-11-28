<?php

namespace App\Observers;

use App\Models\Course;
use App\Traits\FileManagerTrait;

class CourseObserver
{
    use FileManagerTrait;

    public function deleting(Course $course)
    {
        $this->deleteFile($course->image);
        $this->deleteFile($course->course_table);
    }
}
