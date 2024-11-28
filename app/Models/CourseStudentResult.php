<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class CourseStudentResult extends Model
{
    protected $table = 'course_student_results';
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

}
