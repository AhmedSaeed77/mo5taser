<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    protected $guarded = [];

    public function getNameAttribute()
    {
        $lang = \App::getLocale();
        $column = "name_" . $lang;
        return $this->{$column};
    }
}
