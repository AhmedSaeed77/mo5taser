<?php

namespace App\Traits;

trait FileManagerTrait
{
    /**
    * Validates the file from the request & persists it into storage
    * @param String $fileName from request
    * @param String $folder
    * @param String $disk
    * @return Sting $path
    */
    public function upload($fileName = null, $folder = '', $disk = 'public'){
        $path = null;
        if(request()->hasFile($fileName) && request()->file($fileName)->isValid()){
            $path = 'storage/'.request()->file($fileName)->store($folder, $disk);
        }
        return $path;
    }

    /**
    * Validates the file from the request & persists it into storage then unlink old one
    * @param String $fileName from request
    * @param String $folder
    * @param String $oldPath
    * @return Sting $path
    */
    public function updateFile($fileName = null, $folder = '',$oldPath){
        $path = null;
        if(request()->hasFile($fileName) && request()->file($fileName)->isValid()){
            $path = $this->upload($fileName,$folder);
            if(file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        return $path;
    }

    /**
    * Delete the file from the path
    * @param String $oldPath
    */

    public function deleteFile($oldPath){
        if(file_exists($oldPath)) {
            unlink($oldPath);
        }
    }
}
