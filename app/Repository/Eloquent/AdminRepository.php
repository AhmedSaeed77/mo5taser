<?php

namespace App\Repository\Eloquent;

use App\Models\Admin;
use App\Repository\AdminRepositoryInterface;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }
}
