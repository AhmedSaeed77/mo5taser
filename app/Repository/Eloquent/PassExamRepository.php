<?php

namespace App\Repository\Eloquent;

use App\Models\PassExam;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\PassExamRepositoryInterface;

class PassExamRepository extends BaseRepository implements PassExamRepositoryInterface
{
    protected $model;

    public function __construct(PassExam $model)
    {
        $this->model = $model;
    }
}
