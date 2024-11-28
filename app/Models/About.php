<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts';
    protected $guarded = [];

    public function getAboutAttribute()
    {
        $lang = \App::getLocale();
        $column = "about_" . $lang;
        return $this->{$column};
    }
}
