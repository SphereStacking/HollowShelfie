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
        return Storage::disk('public')->url($this->path.'/'.$this->name);
    }

    /**
     * ファイルの削除
     */
    public function deleteFile(): void
    {
        Storage::disk('public')->delete($this->path.'/'.$this->name);
    }

    /**
     * file
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
