<?php

namespace App\Models;

use App\Models\Course;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $table = 'coupons';
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id')->withoutGlobalScopes();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
