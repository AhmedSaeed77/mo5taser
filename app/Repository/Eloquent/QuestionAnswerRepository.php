<?php

namespace App\Repository\Eloquent;

use App\Models\QACourse;
use App\Repository\QuestionAnswerRepositoryInterface;

class QuestionAnswerRepository extends BaseRepository implements QuestionAnswerRepositoryInterface
{
    protected $model;

    public function __construct(QACourse $model)
    {
        $this->model = $model;
    }
}
