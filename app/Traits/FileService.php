<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileService
{
    public function storeAttachment($attachments)
    {
        if ($attachments) {
            $foldername = Str::ulid();

            foreach ($attachments as $attachment) {
                $filename = $attachment->getClientOriginalName();
                Storage::putFileAs('attachments/' . $foldername, $attachment, $filename);
            }

            return $foldername;
        }
    }

    public function getAttachment($foldername)
    {
        if ($foldername) {
            $files = Storage::files('attachments/' . $foldername);
            $fileData = [];

            foreach ($files as $file) {
                $fileData[] = [
                    'path' => $file,
                    'name' => basename($file),
                ];
            }

            return $fileData;
        }
    }
}
