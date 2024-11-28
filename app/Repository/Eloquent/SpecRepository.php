<?php

namespace App\Repository\Eloquent;

use App\Models\Spec;
use App\Repository\SpecRepositoryInterface;

class SpecRepository extends BaseRepository implements SpecRepositoryInterface
{
    protected $model;

    public function __construct(Spec $model)
    {
        $this->model = $model;
    }
}
