<?php

namespace App\Observers;

use App\Models\Subscribe;
use App\Traits\FileManagerTrait;

class SubscribeObserver
{
    use FileManagerTrait;

    public function deleting(Subscribe $subscribe)
    {
        $this->deleteFile($subscribe->image);
    }
}
