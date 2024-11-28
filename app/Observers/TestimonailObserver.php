<?php

namespace App\Observers;

use App\Models\Testimonail;
use App\Traits\FileManagerTrait;

class TestimonailObserver
{
    use FileManagerTrait;

    public function deleting(Testimonail $testimonail)
    {
        $this->deleteFile($testimonail->image);
    }
}
