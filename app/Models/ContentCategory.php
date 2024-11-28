<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentCategory extends Model
{
    protected $table = 'content_categories';
    protected $guarded = [];


    public function getNameAttribute()
    {
        $lang = \App::getLocale();
        $column = "name_" . $lang;
        return $this->{$column};
    }

    public function content()
    {
        return $this->belongsTo(Content::class,'content_id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class , 'content_category_id');
    }
}
