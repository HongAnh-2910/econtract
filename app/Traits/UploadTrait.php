<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadOneFile(UploadedFile $uploadedFile, $folder, $disk, $filename)
    {
        //disk: storage, public, ..
        $uploadedFile->move(base_path($disk . '/' . $folder), $filename);

        return $uploadedFile;
    }

    public function removeOneFile($filename)
    {
        $isIssetFile = Storage::exists('uploads/' . $filename);
        if ($isIssetFile) {
            unlink(storage_path('uploads/' . $filename));
        } else {
            Session::flash('error_message', 'File không tồn tại!');
        }
    }
}
