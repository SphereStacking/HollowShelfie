<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadFile(UploadedFile $uploadedFile, $fileable): File
    {
        $folderName = strtolower(class_basename($fileable)) . '/' . $fileable->id;
        $filename = $uploadedFile->hashName();
        $savePath = Storage::disk('public')->putFileAs($folderName, $uploadedFile, $filename);

        if (!$savePath) {
            throw new \Exception('ファイルの保存に失敗しました。');
        }

        $file = $fileable->files()->create([
            'path' => $folderName,
            'name' => $filename,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'type' => $uploadedFile->getClientMimeType(),
        ]);

        return $file;
    }

    public function deleteFile(File $file)
    {
        $file->deleteFile();
        $file->delete();
    }

    public function deleteFileById( $id)
    {
        $file = File::findOrFail($id);
        $file->deleteFile();
        $file->delete();
    }
}
