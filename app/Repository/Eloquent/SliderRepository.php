<?php

namespace App\Repository\Eloquent;

use App\Models\Slider;
use App\Repository\SliderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SliderRepository extends BaseRepository implements SliderRepositoryInterface
{
    protected $model;

    public function __construct(Slider $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::getAll($columns, $relations)->sortBy('id');
    }
}
