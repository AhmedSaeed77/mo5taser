<?php

namespace App\Repository\Eloquent;

use App\Models\Bank;
use App\Repository\BankRepositoryInterface;

class BankRepository extends BaseRepository implements BankRepositoryInterface
{
    protected $model;

    public function __construct(Bank $model)
    {
        $this->model = $model;
    }
}
