<?php

namespace App\Models;

use App\Models\StudentExam;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Model;

class PassExam extends Model
{
    protected $table = 'pass_exams';
    protected $guarded = [];

    public function mainCat()
    {
        return $this->belongsTo(Category::class,'main_cat');
    }
    public function levelCat()
    {
        return $this->belongsTo(Category::class,'level');
    }
    public function teacher()
    {
        return $this->belongsTo(Admin::class,'teacher_id');
    }

    public function mainLevel()
    {
        return $this->belongsTo(Category::class , 'main_cat');
    }
    public function childLevel()
    {
        return $this->belongsTo(Category::class , 'level');
    }
    public function attempts()
    {
        return $this->hasMany(StudentExam::class , 'exam_id');
    }

    public function questions() {
        return $this->hasMany(Question::class, 'exam_id');
    }


    public function restAttempts()
    {
       $user = JWTAuth::user();
       $rest = 0;
       if($user)
       {
           $rest = StudentExam::where(['user_id' => JWTAuth::user()->id,'status' => 0,])
           ->where('exam_id', $this->id)->get()->count();
       }


       return $this->attemps - $rest;
    }
}


