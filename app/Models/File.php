<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = ['path', 'type', 'name', 'original_name'];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'public_url',
    ];

    /**
     * ファイルへのアクセスURL
     */
    public function getPublicUrlAttribute(): string
    {
        return Storage::disk(config('filesystems.default'))->url($this->path).'/'.$this->name;
    }

    /**
     * ファイルの削除
     */
    public function deleteFile(): void
    {
        Storage::disk(config('filesystems.default'))->delete($this->path.'/'.$this->name);
    }

    /**
     * file
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * ファイルの保存
     */
    public static function saveFile($fileable, $uploadedFile): self
    {
        $folderName = mb_strtolower(class_basename($fileable)).'/'.$fileable->id;
        $filename = $uploadedFile->hashName();
        $savePath = Storage::disk(config('filesystems.default'))->putFileAs($folderName, $uploadedFile, $filename);

        if (! $savePath) {
            throw new \Exception('ファイルの保存に失敗しました。');
        }

        return $fileable->files()->create([
            'path' => $savePath,
            'name' => $filename,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'type' => $uploadedFile->getClientMimeType(),
        ]);
    }

}
