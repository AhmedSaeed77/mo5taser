<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyUs extends Model
{
    protected $table = 'why_us';
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
}
