<?php

namespace App\Observers;

use App\Models\Team;
use App\Traits\FileManagerTrait;

class TeamObserver
{
    use FileManagerTrait;

    public function deleting(Team $about)
    {
        $this->deleteFile($about->image);
    }
}
