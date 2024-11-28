<?php

namespace App\Repository\Eloquent;

use App\Models\Subject;
use App\Repository\SubjectRepositoryInterface;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{
    protected $model;

    public function __construct(Subject $model)
    {
        $this->model = $model;
    }
}
