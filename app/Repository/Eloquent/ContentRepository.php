<?php

namespace App\Repository\Eloquent;

use App\Models\Content;
use App\Repository\ContentRepositoryInterface;

class ContentRepository extends BaseRepository implements ContentRepositoryInterface
{
    protected $model;

    public function __construct(Content $model)
    {
        $this->model = $model;
    }
}
