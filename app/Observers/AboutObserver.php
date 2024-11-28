<?php

namespace App\Observers;

use App\Models\About;
use App\Traits\FileManagerTrait;

class AboutObserver
{
    use FileManagerTrait;

    public function deleting(About $about)
    {
        $this->deleteFile($about->image);
        $this->deleteFile($about->cover);
    }
}
