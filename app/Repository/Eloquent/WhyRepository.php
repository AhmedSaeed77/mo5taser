<?php

namespace App\Repository\Eloquent;

use App\Models\WhyUs;
use App\Repository\WhyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WhyRepository extends BaseRepository implements WhyRepositoryInterface
{
    protected $model;

    public function __construct(WhyUs $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::getAll($columns, $relations)->sortBy('id');
    }
}
