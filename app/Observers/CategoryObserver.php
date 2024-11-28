<?php

namespace App\Observers;

use App\Models\Category;
use App\Traits\FileManagerTrait;

class CategoryObserver
{
    use FileManagerTrait;

    public function deleting(Category $category)
    {
        $this->deleteFile($category->image);
    }
}
