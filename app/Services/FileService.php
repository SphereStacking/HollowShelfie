<?php

namespace App\Services;

use App\Models\File;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadFile(UploadedFile $uploadedFile, $fileable): File
    {
        $folderName = mb_strtolower(class_basename($fileable)).'/'.$fileable->id;
        $filename = $uploadedFile->hashName();
        $savePath = Storage::disk('public')->putFileAs($folderName, $uploadedFile, $filename);

        if (! $savePath) {
            throw new Exception('ファイルの保存に失敗しました。');
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

    public function deleteFileById($id)
    {
        $file = File::findOrFail($id);
        $file->deleteFile();
        $file->delete();
    }
}
