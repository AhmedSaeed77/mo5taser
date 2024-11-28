<?php

namespace App\Repository\Eloquent;

use App\Models\ContentComment;
use App\Repository\ContentCommentRepositoryInterface;

class ContentCommentRepository extends BaseRepository implements ContentCommentRepositoryInterface
{
    protected $model;

    public function __construct(ContentComment $model)
    {
        $this->model = $model;
    }
}
