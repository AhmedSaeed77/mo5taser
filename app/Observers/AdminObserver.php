<?php

namespace App\Observers;

use App\Models\Admin;
use App\Traits\FileManagerTrait;

class AdminObserver
{
    use FileManagerTrait;

    public function deleting(Admin $admin)
    {
        $this->deleteFile($admin->image);
    }
}
