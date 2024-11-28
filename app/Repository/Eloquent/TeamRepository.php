<?php

namespace App\Repository\Eloquent;

use App\Models\Team;
use App\Repository\TeamRepositoryInterface;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    protected $model;

    public function __construct(Team $model)
    {
        $this->model = $model;
    }
}
