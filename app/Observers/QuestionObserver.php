<?php

namespace App\Observers;

use App\Models\Question;
use App\Traits\FileManagerTrait;

class QuestionObserver
{
    use FileManagerTrait;

    public function deleting(Question $question)
    {
        $this->deleteFile($question->image);
        $this->deleteFile($question->hint_image);
    }
}
