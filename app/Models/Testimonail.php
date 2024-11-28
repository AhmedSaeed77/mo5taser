<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonail extends Model
{
    protected $table = 'testimonails';
    protected $guarded = [];

    public function getCommentAttribute()
    {
        $lang = \App::getLocale();
        $column = "comment_" . $lang;
        return $this->{$column};
    }
}

