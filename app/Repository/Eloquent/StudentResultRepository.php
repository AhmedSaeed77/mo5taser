<?php

namespace App\Repository\Eloquent;

use App\Models\CourseStudentResult;
use App\Repository\StudentResultRepositoryInterface;

class StudentResultRepository extends BaseRepository implements StudentResultRepositoryInterface
{
    protected $model;

    public function __construct(CourseStudentResult $model)
    {
        $this->model = $model;
    }
}
