<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progress';
    protected $guarded = [];

    public function content() {
        return $this->belongsTo(Content::class);
    }
}

