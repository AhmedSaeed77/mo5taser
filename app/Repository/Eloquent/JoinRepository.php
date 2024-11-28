<?php

namespace App\Repository\Eloquent;

use App\Models\Join;
use App\Repository\JoinRepositoryInterface;

class JoinRepository extends BaseRepository implements JoinRepositoryInterface
{
    protected $model;

    public function __construct(Join $model)
    {
        $this->model = $model;
    }
}
