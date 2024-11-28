<?php

namespace App\Repository\Eloquent;

use App\Models\Privacy;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\PrivacyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PrivacyRepository extends BaseRepository implements PrivacyRepositoryInterface
{
    protected $model;

    public function __construct(Privacy $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::getAll($columns, $relations)->sortBy('id');
    }
}
