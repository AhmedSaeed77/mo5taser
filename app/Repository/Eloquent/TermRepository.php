<?php

namespace App\Repository\Eloquent;

use App\Models\Term;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\TermRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TermRepository extends BaseRepository implements TermRepositoryInterface
{
    protected $model;

    public function __construct(Term $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::getAll($columns, $relations)->sortBy('id');
    }
}
