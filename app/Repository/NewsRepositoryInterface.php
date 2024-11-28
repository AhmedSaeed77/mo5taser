<?php

namespace App\Repository;

interface NewsRepositoryInterface extends EloquentRepositoryInterface {

    public function getLatest();

}
