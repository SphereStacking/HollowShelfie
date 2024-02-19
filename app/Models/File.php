<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'type','name','original_name'];


    /**
     * @var array
     */
    protected $appends = [
        'public_url',
    ];

    public function getPublicUrlAttribute()
    {
        return Storage::disk("public")->url($this->path . '/' . $this->name);
    }

    public function fileable()
    {
        return $this->morphTo();
    }


}
