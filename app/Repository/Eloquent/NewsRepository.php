<?php

namespace App\Repository\Eloquent;

use App\Models\News;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\NewsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository extends BaseRepository implements NewsRepositoryInterface
{
    protected $model;

    public function __construct(News $model)
    {
        $this->model = $model;
    }

    public function getLatest() {
        return $this->model::query()->orderByDesc('updated_at')->get();
    }

    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::getAll($columns, $relations)->sortBy('id');
    }
}
