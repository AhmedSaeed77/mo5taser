<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    protected $table = 'specs';
    protected $guarded = [];

    public function getTitleAttribute()
    {
        $lang = \App::getLocale();
        $column = "title_" . $lang;
        return $this->{$column};
    }
}

