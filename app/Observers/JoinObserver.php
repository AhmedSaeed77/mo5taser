<?php

namespace App\Observers;

use App\Models\Join;
use App\Traits\FileManagerTrait;

class JoinObserver
{
    use FileManagerTrait;

    public function deleting(Join $join)
    {
        $this->deleteFile($join->cv);
    }
}
