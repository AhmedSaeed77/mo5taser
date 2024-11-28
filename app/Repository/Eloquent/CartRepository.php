<?php

namespace App\Repository\Eloquent;

use App\Models\Cart;
use App\Repository\CartRepositoryInterface;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }
}
