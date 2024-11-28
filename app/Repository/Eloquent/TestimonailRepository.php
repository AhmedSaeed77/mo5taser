<?php

namespace App\Repository\Eloquent;

use App\Models\Testimonail;
use App\Repository\TestimonailRepositoryInterface;

class TestimonailRepository extends BaseRepository implements TestimonailRepositoryInterface
{
    protected $model;

    public function __construct(Testimonail $model)
    {
        $this->model = $model;
    }
}
