<?php

namespace App\Observers;

use App\Models\Content;
use App\Traits\FileManagerTrait;
use Illuminate\Support\Facades\Log;

class ContentObserver
{
    use FileManagerTrait;

    public function deleting(Content $content)
    {
        $this->deleteFile($content->image);
        $this->deleteFile($content->attachement);
        $admin = auth('admin')->user();
        Log::info('########################################################################################################################');
        Log::info('ElRyad: Admin (' . $admin->name . ') with email (' . $admin->email . ') deleted course content (' . $content->title . ')');
        Log::info('########################################################################################################################');
    }
}
