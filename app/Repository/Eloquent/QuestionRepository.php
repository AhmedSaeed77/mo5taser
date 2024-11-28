<?php

namespace App\Repository\Eloquent;

use App\Models\Question;
use App\Repository\QuestionRepositoryInterface;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    protected $model;

    public function __construct(Question $model)
    {
        $this->model = $model;
    }
}
