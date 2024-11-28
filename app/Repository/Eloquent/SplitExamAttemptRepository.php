<?php

namespace App\Repository\Eloquent;

use App\Models\SplitExamAttempt;
use App\Repository\SplitExamAttemptRepositoryInterface;

class SplitExamAttemptRepository extends BaseRepository implements SplitExamAttemptRepositoryInterface
{
    protected $model;

    public function __construct(SplitExamAttempt $model)
    {
        $this->model = $model;
    }
}
