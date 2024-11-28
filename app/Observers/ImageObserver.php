<?php

namespace App\Observers;

use App\Models\Image;
use App\Traits\FileManagerTrait;

class ImageObserver
{
    use FileManagerTrait;

    public function deleting(Image $image)
    {
        $this->deleteFile($image->image_login);
        $this->deleteFile($image->image_register);
        $this->deleteFile($image->image_join_us);
        $this->deleteFile($image->image_top_logo);
        $this->deleteFile($image->image_footer_logo);
        $this->deleteFile($image->image_fav);
    }
}
