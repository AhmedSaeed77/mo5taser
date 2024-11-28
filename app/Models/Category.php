<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [];

    public function getTitleAttribute()
    {
        $lang = \App::getLocale();
        $column = "title_" . $lang;
        return $this->{$column};
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function courses()
    {
        return $this->hasMany(Course::class,'category_id');
    }

    public function passExam()
    {
        return $this->hasOne(PassExam::class,'level');
    }

    public function exams()
    {
        return $this->hasMany(PassExam::class,'level');
    }

    public function assemblies()
    {
        return $this->hasMany(Assemble::class,'category_id');
    }

    public function scopeType($query,$type)
    {
        return $query->where('type' , 'like' , $type)->where('parent_id' , NULL);
    }

    public function scopeCategory($query,$type)
    {
        return $query->where('type' , 'like' , $type);
    }


}

