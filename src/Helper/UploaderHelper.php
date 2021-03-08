<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    private string $uploadsPath;

    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadImage(UploadedFile $uploadedFile): string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileRename = $originalFilename.'_'.md5(uniqid('', true)).'.'.$uploadedFile->guessExtension();
        $uploadedFile->move($this->uploadsPath, $fileRename);

        return $fileRename;
    }

    public function removeImage(string $imageName): void
    {
        $path = $this->uploadsPath.$imageName;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}