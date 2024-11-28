<?php

namespace App\Observers;

use App\Models\Slider;
use App\Traits\FileManagerTrait;

class SliderObserver
{
    use FileManagerTrait;

    public function deleting(Slider $slider)
    {
        $this->deleteFile($slider->image);
    }
}
