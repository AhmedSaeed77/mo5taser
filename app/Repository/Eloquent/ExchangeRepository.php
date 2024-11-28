<?php

namespace App\Repository\Eloquent;

use App\Models\Exchange;
use App\Repository\ExchangeRepositoryInterface;

class ExchangeRepository extends BaseRepository implements ExchangeRepositoryInterface
{
    protected $model;

    public function __construct(Exchange $model)
    {
        $this->model = $model;
    }
}
