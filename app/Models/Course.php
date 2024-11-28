<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Rating;
use App\Models\Content;
use App\Models\Progress;
use App\Scopes\ActiveScope;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
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

    public function teachers()
    {
        return $this->belongsToMany(Admin::class,'course_teachers','course_id','teacher_id')->distinct();
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Rating::class , 'course_id');
    }

    public function questions()
    {
        return $this->hasMany(QACourse::class , 'course_id');
    }

    public function results()
    {
        return $this->hasMany(CourseStudentResult::class , 'course_id');
    }

    public function averageRate()
    {
        $stars = Rating::where('course_id',$this->id)->get()->pluck('rating')->toArray();
        $stars_sum = array_sum($stars);
        $stars_count = sizeOf($stars);

        if($stars_count > 0)
        {
            return number_format($stars_sum / $stars_count, 1);
        }
        else
        {
            return 0;
        }
    }

    public function ratingCount()
    {
        return Rating::where('course_id',$this->id)->get()->count();
    }

    public function rated()
    {
        $user = JWTAuth::user();
        if($user)
        {
            $rated =  Rating::where(['course_id' => $this->id,'user_id' => JWTAuth::user()->id])->first();

            if($rated)
            {
                return true;
            }
            return false;
        }
        else
        {
            return false;
        }
    }

    public function progress($user_id)
    {
       $progress = 0;
       if(auth('admin')->check())
       {
           $course_contents = Content::where(['course_id' => $this->id])->whereIn('type',['video','zoom','exam','homework'])->get();
           $progress_contents = Progress::whereIn('content_id' , $course_contents->pluck('id')->toArray())->where(['user_id' => $user_id])->get()->count();
           if($course_contents->count() > 0)
           {
               $progress = floor($progress_contents / $course_contents->count() * 100);
           }

       }

       return $progress;
    }

    public function subscribes() {
        return $this->hasMany(Subscribe::class);
    }

    public function subscribers()
    {
       return count(Subscribe::where('course_id',$this->id)->get());
    }

    public function subscribed()
    {
        if(auth()->check())
        {
            return Subscribe::where(['course_id' =>$this->id, 'user_id' => auth()->id(), 'active' => 1])->first();
        }
        else
        {
            return false;
        }
    }

    public function subscribedApi()
    {
        $user = JWTAuth::user();
        if($user)
        {
            $subscribe = Subscribe::where(['course_id' =>$this->id, 'user_id' => $user->id,'active' => 1])->first();
            if($subscribe)
            {
                if($subscribe->end_subscribe != null)
                {
                    $input = $subscribe->end_subscribe;
                    $date = strtotime($input);
                    if(date('Y-m-d') < date('Y-m-d', $date))
                    {
                        return true;
                    }
                    else
                    {
                        $subscribe->update([
                            'end_subscribe' => null,
                            'active' => 0,
                        ]);

                        return false;
                    }

                }

            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function apiProgress()
    {
       $user = JWTAuth::user();
       $progress = 0;
       if($user)
       {
           $course_contents = Content::where(['course_id' => $this->id])->whereIn('type',['video','zoom','exam','homework'])->get();
           $progress_contents = Progress::whereIn('content_id' , $course_contents->pluck('id')->toArray())->where(['user_id' => $user->id])->get()->count();
           if($course_contents->count() > 0)
           {
               $progress = floor($progress_contents / $course_contents->count() * 100);
           }

       }

       return $progress;
    }

    public function myRate()
    {
        $me = 0;
        $user = JWTAuth::user();
        if($user)
        {
            $rated =  Rating::where(['course_id' => $this->id,'user_id' => JWTAuth::user()->id])->first();

            if($rated)
            {
                return true;
            }
            return false;
        }
        else
        {
            return false;
        }
    }
}
