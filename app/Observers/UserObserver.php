<?php

namespace App\Observers;

use App\Models\User;
use App\Traits\FileManagerTrait;

class UserObserver
{
    use FileManagerTrait;

    public function deleting(User $category)
    {
        $this->deleteFile($category->image);
    }
}
