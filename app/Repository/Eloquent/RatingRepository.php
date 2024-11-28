<?php

namespace App\Repository\Eloquent;

use App\Models\Rating;
use App\Repository\RatingRepositoryInterface;

class RatingRepository extends BaseRepository implements RatingRepositoryInterface
{
    protected $model;

    public function __construct(Rating $model)
    {
        $this->model = $model;
    }
}
