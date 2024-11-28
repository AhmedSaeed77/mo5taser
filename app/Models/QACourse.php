<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QACourse extends Model
{
    protected $table = 'q_a_courses';
    protected $guarded = [];
    public function getQuestionAttribute()
    {
        $lang = \App::getLocale();
        $column = "question_" . $lang;
        return $this->{$column};
    }

    public function getAnswerAttribute()
    {
        $lang = \App::getLocale();
        $column = "answer_" . $lang;
        return $this->{$column};
    }
}

