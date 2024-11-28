<?php

namespace App\Observers;

use App\Models\Assemble;
use App\Traits\FileManagerTrait;

class AssembleObserver
{
    use FileManagerTrait;

    public function deleting(Assemble $assemble)
    {
        $this->deleteFile($assemble->image);
        $this->deleteFile($assemble->book);
        $this->deleteFile($assemble->book_preview);
    }
}
