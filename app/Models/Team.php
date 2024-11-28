<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    protected $guarded = [];

    public function getJobAttribute()
    {
        $lang = \App::getLocale();
        $column = "job_" . $lang;
        return $this->{$column};
    }

    public function getNameAttribute()
    {
        $lang = \App::getLocale();
        $column = "name_" . $lang;
        return $this->{$column};
    }
}
