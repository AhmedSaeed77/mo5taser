<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    protected $table = 'student_exams';
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function passExam()
    {
        return $this->belongsTo(PassExam::class,'exam_id');
    }
    public function content()
    {
        return $this->belongsTo(Content::class,'content_id');
    }
    public function contentCategory()
    {
        return $this->belongsTo(ContentCategory::class,'content_category_id');
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class,'attemp_id');
    }


}
