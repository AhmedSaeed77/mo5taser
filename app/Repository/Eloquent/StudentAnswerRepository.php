<?php

namespace App\Repository\Eloquent;

use App\Models\StudentAnswer;
use App\Repository\StudentAnswerRepositoryInterface;

class StudentAnswerRepository extends BaseRepository implements StudentAnswerRepositoryInterface
{
    protected $model;

    public function __construct(StudentAnswer $model)
    {
        $this->model = $model;
    }
}
