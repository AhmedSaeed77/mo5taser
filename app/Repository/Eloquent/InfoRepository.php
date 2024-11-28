<?php

namespace App\Repository\Eloquent;

use App\Models\Info;
use App\Repository\InfoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class InfoRepository extends BaseRepository implements InfoRepositoryInterface
{
    protected $model;

    public function __construct(Info $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::getAll($columns, $relations)->sortBy('id');
    }
}
