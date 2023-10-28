<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\File;

class FileService
{
    public function uploadFile(UploadedFile $uploadedFile, $fileable)
    {
        // フォルダ名をリソースのクラス名とIDで構築
        $folder_root = 'uploads';
        $folder_fileable = strtolower(class_basename($fileable));
        $folder_id = $fileable->id;

        // 例： uploads/events/1, uploads/events/2, ...
        $path = $folder_root . '/' .  $folder_fileable . '/' . $folder_id;

        // ファイルをストレージに保存
        // file名衝突はlaravelが良くやってくれるらしい。
        $filename = $uploadedFile->store($path);

        // データベースに情報を保存
        $file = new File([
            'name' => $filename,
            'type' => $uploadedFile->getClientMimeType(),
        ]);

        $fileable->files()->save($file);

        return $file;
    }
}
