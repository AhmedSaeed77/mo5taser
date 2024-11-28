<?php

namespace App\Observers;

use App\Models\News;
use App\Traits\FileManagerTrait;

class NewsObserver
{
    use FileManagerTrait;

    public function deleting(News $new)
    {
        $this->deleteFile($new->image);
    }
}
