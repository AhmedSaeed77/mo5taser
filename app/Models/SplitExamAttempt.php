<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplitExamAttempt extends Model
{
    use HasFactory;
    protected $table = 'split_exam_attempts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function content()
    {
        return $this->belongsTo(Content::class,'content_id');
    }
}

