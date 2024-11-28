<?php

namespace App\Repository\Eloquent;

use App\Models\About;
use App\Repository\AboutRepositoryInterface;

class AboutRepository extends BaseRepository implements AboutRepositoryInterface
{
    protected $model;

    public function __construct(About $model)
    {
        $this->model = $model;
    }
}
