<?php

namespace App\Repository\Eloquent;

use App\Models\StudentExam;
use App\Repository\StudentExamRepositoryInterface;

class StudentExamRepository extends BaseRepository implements StudentExamRepositoryInterface
{
    protected $model;

    public function __construct(StudentExam $model)
    {
        $this->model = $model;
    }
}
