<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assemble extends Model
{
    use HasFactory;
    protected $table = 'assembles';
    protected $guarded = [];

    public function getTitleAttribute()
    {
        $lang = \App::getLocale();
        $column = "title_" . $lang;
        return $this->{$column};
    }
    public function getContentAttribute()
    {
        $lang = \App::getLocale();
        $column = "content_" . $lang;
        return $this->{$column};
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

}

