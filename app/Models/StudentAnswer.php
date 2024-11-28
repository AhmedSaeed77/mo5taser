<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $table = 'student_answers';
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
}
