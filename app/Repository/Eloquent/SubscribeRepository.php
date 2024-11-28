<?php

namespace App\Repository\Eloquent;

use App\Models\Subscribe;
use App\Repository\SubscribeRepositoryInterface;

class SubscribeRepository extends BaseRepository implements SubscribeRepositoryInterface
{
    protected $model;

    public function __construct(Subscribe $model)
    {
        $this->model = $model;
    }
}
