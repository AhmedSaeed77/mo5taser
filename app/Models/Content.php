<?php

namespace App\Models;

use App\Models\StudentExam;
use App\Scopes\ActiveScope;
use App\Models\ContentCategory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'contents';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);
    }

    public function getTitleAttribute()
    {
        $lang = \App::getLocale();
        $column = "title_" . $lang;
        return $this->{$column};
    }
    public function getDescAttribute()
    {
        $lang = \App::getLocale();
        $column = "desc_" . $lang;
        return $this->{$column};
    }
    public function getInstructionsAttribute()
    {
        $lang = \App::getLocale();
        $column = "instructions_" . $lang;
        return $this->{$column};
    }

    public function parent()
    {
        return $this->belongsTo(Content::class,'parent_id')->withoutGlobalScopes();
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function childs()
    {
        return $this->hasMany(Content::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }


    public function getExamined()
    {
        if($this->type == 'split_test')
        {
            $categories = ContentCategory::where('content_id',$this->id)->get();
            $attempts = StudentExam::where(['content_id' => $this->id,'status' => 0,'user_id' => auth()->id()])->
            whereIn('content_category_id',$categories->pluck('id')->toArray())->get()->count();

            $attempts_count = $categories->count() !== 0 ? ((int)($attempts / $categories->count())) : 0;
        }
        else
        {
            $attempts_count = StudentExam::where(['content_id' => $this->id,'status' => 0,'user_id' => auth()->id()])->get()->count();
        }
        return $attempts_count;
    }

    public function comments()
    {
        return $this->hasMany(ContentComment::class , 'content_id')->where('parent_id',NULL);
    }

    public function questions()
    {
        return $this->hasMany(Question::class , 'content_id');
    }
    public function categories()
    {
        return $this->hasMany(ContentCategory::class,'content_id');
    }



    public function progressable()
    {
        $user = JWTAuth::user();

        if($user)
        {
            $progress = Progress::where(['content_id' =>$this->id, 'user_id' => $user->id])->first();
            if($progress)
            {
                return 1;
            }

            return 0;
        }
        else
        {
            return 0;
        }
    }

    public function contentCategoryCount()
    {
        if($this->type == 'split_test')
        {
            $categories = ContentCategory::where('content_id',$this->id)->get();
            return $categories->count();
        }
        else
        {
            return NULL;
        }
    }
}
