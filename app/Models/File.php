<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'type', 'name', 'original_name'];

    /**
     * @var array
     */
    protected $appends = [
        'public_url',
    ];

    public function getPublicUrlAttribute()
    {
        return Storage::disk('public')->url($this->path.'/'.$this->name);
    }

    public function deleteFile()
    {
        Storage::disk('public')->delete($this->path.'/'.$this->name);
    }

    public function fileable()
    {
        return $this->morphTo();
    }
}
