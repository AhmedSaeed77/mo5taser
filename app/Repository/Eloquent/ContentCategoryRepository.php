<?php

namespace App\Repository\Eloquent;

use App\Models\ContentCategory;
use App\Repository\ContentCategoryRepositoryInterface;

class ContentCategoryRepository extends BaseRepository implements ContentCategoryRepositoryInterface
{
    protected $model;

    public function __construct(ContentCategory $model)
    {
        $this->model = $model;
    }
}
