<?php

namespace App\Repository\Eloquent;

use App\Models\Course;
use App\Repository\CourseRepositoryInterface;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    protected $model;

    public function __construct(Course $model)
    {
        $this->model = $model;
    }
}
