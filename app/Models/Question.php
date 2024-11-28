<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
    public function content()
    {
        return $this->belongsTo(Content::class,'content_id');
    }

    public function exam() {
        return $this->belongsTo(PassExam::class, 'exam_id');
    }

    public function subjectName()
    {
        if($this->subject->parent)
        {
            if($this->subject->parent->parent)
            {
                return $this->subject->parent->parent->name . ' - ' . $this->subject->parent->name . ' - ' . $this->subject->name;
            }
            else
            {
                return  $this->subject->parent->name . ' - ' . $this->subject->name;
            }
        }
        else
        {
            return $this->subject->name;

        }
    }
    public function subjectId()
    {
        $subjects_arr = [];
        if($this->subject->parent)
        {
            if($this->subject->parent->parent)
            {
                array_push($subjects_arr,$this->subject->parent->parent->id);
                array_push($subjects_arr,$this->subject->parent->id);
                array_push($subjects_arr,$this->subject->id);
                return $subjects_arr;
            }
            else
            {
                array_push($subjects_arr,$this->subject->parent->id);
                array_push($subjects_arr,$this->subject->id);
                return $subjects_arr;
            }
        }
        else
        {
            array_push($subjects_arr,$this->subject->id);
            return $subjects_arr;
        }
    }

    public function contentCategory()
    {
        return $this->belongsTo(ContentCategory::class,'content_category_id');
    }
}

