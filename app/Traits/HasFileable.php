<?php
namespace App\Traits;

use App\Models\File;

trait HasFileable
{
    /**
     * ファイルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

}
