<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    protected $model;

    public function __construct(Image $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::getAll($columns, $relations)->sortBy('id');
    }
}
