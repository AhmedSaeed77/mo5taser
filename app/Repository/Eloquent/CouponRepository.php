<?php

namespace App\Repository\Eloquent;

use App\Models\Coupon;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\CouponRepositoryInterface;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    protected $model;

    public function __construct(Coupon $model)
    {
        $this->model = $model;
    }
}
