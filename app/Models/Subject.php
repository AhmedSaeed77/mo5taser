<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $guarded = [];

    public function getNameAttribute()
    {
        $lang = \App::getLocale();
        $column = "name_" . $lang;
        return $this->{$column};
    }

    public function parent()
    {
        return $this->belongsTo(Subject::class,'parent_id');
    }
}
