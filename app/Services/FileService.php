<?php

namespace App\Services;

use Exception;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\FileServiceException;

class FileService
{
    public function uploadFile(UploadedFile $uploadedFile, $fileable): File
    {
        try {
            return File::saveFile($fileable, $uploadedFile);
        } catch (Exception $e) {
            Log::error('ファイルのアップロード中にエラーが発生しました: ' . $e->getMessage());
            throw new FileServiceException('ファイルのアップロード中にエラーが発生しました。');
        }
    }

    public function deleteFile(File $file)
    {
        try {
            // R2からファイルを削除
            $file->deleteFile();

            // データベースからファイル情報を削除
            $file->delete();
        } catch (Exception $e) {
            Log::error('ファイルの削除中にエラーが発生しました: ' . $e->getMessage());
            throw new FileServiceException('ファイルの削除中にエラーが発生しました。');
        }
    }

    public function deleteFileById($id)
    {
        try {
            $file = File::findOrFail($id);

            // R2からファイルを削除
            $file->deleteFile();

            // データベースからファイル情報を削除
            $file->delete();
        } catch (Exception $e) {
            Log::error('ファイルの削除中にエラーが発生しました: ' . $e->getMessage());
            throw new FileServiceException('ファイルの削除中にエラーが発生しました。');
        }
    }
}
