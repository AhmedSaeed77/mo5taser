<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
