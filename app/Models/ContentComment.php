<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentComment extends Model
{
    protected $table = 'content_comments';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Admin::class,'teacher_id');
    }

    public function childs()
    {
        return $this->hasMany(ContentComment::class , 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(ContentComment::class,'parent_id');
    }
}
